<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'https://plafondi.com');
    }

    /**
     * @return array<string, mixed>
     */
    private function schema(): array
    {
        preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $this->get('/')->getContent(), $match);

        return json_decode($match[1], true, flags: JSON_THROW_ON_ERROR);
    }

    public function test_the_page_tells_google_what_it_is_about(): void
    {
        $response = $this->get('/');

        $response->assertSee('<title>გასაჭიმი ჭერები თბილისში: ფასები და მონტაჟი | Plafondi</title>', false);
        $response->assertSee('<meta name="description" content="გასაჭიმი ჭერის მონტაჟი', false);
        $response->assertSee('21 ₾-დან მ²-ზე', false);
        $response->assertSee('<link rel="canonical" href="https://plafondi.com/">', false);
        $response->assertSee('<meta property="og:image" content="'.asset('images/og-image.jpg').'">', false);
    }

    public function test_the_main_heading_names_the_product(): void
    {
        preg_match('#<h1>(.+?)</h1>#s', $this->get('/')->getContent(), $match);

        $this->assertStringContainsString('გასაჭიმი ჭერები', strip_tags($match[1]));
    }

    public function test_the_business_details_list_the_area_and_prices(): void
    {
        $business = collect($this->schema()['@graph'])->firstWhere('@type', 'HomeAndConstructionBusiness');

        $this->assertSame('Plafondi', $business['name']);
        $this->assertSame(['თბილისი', 'მცხეთა', 'რუსთავი'], array_column($business['areaServed'], 'name'));
        $this->assertSame([21, 23, 25], array_column(array_column($business['hasOfferCatalog']['itemListElement'], 'priceSpecification'), 'price'));
    }

    public function test_placeholder_contacts_are_not_given_to_google(): void
    {
        config()->set('homepage.contact.placeholder', true);
        $business = collect($this->schema()['@graph'])->firstWhere('@type', 'HomeAndConstructionBusiness');
        $this->assertArrayNotHasKey('telephone', $business);

        config()->set('homepage.contact.placeholder', false);
        config()->set('homepage.contact.phone', '+995 599 12 34 56');
        $business = collect($this->schema()['@graph'])->firstWhere('@type', 'HomeAndConstructionBusiness');
        $this->assertSame('+995599123456', $business['telephone']);
    }

    public function test_the_faq_answers_quote_current_prices(): void
    {
        config()->set('homepage.pricing.finishes.matte.price', 19);

        $response = $this->get('/');
        $faq = collect($this->schema()['@graph'])->firstWhere('@type', 'FAQPage');

        $response->assertSee('id="faq"', false);
        $response->assertSee('მქრქალი ჭერის კვადრატული მეტრი 19 ₾ ღირს');
        $this->assertCount(count(config('homepage.faq.items')), $faq['mainEntity']);

        foreach (\App\Support\Faq::items(config('homepage')) as $item) {
            $this->assertDoesNotMatchRegularExpression('/\{[a-z_.]+\}/', $item['answer'], 'Unknown price in: '.$item['question']);
        }
    }

    public function test_llms_txt_summarises_the_business_for_ai_assistants(): void
    {
        $response = $this->get('/llms.txt');

        $response->assertOk();
        $response->assertSee('# Plafondi', false);
        $response->assertSee('- მქრქალი: 21 ₾ / მ²', false);
        $response->assertSee('### რა ღირს გასაჭიმი ჭერი?', false);
        $response->assertDontSee('+995 555 00 00 00', false);
    }

    public function test_robots_txt_points_to_the_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap: https://plafondi.com/sitemap.xml', false);
    }

    public function test_the_sitemap_lists_the_page_and_every_project_photo(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = simplexml_load_string($response->getContent());
        $this->assertSame('https://plafondi.com/', (string) $xml->url->loc);
        $this->assertCount(count(config('homepage.photos')), $xml->url->children('image', true));
    }

    public function test_the_icons_and_preview_image_exist(): void
    {
        foreach (['favicon.ico', 'favicon.svg', 'apple-touch-icon.png', 'images/logo.png', 'images/og-image.jpg'] as $file) {
            $this->assertFileExists(public_path($file));
            $this->assertGreaterThan(0, filesize(public_path($file)), $file);
        }

        $this->assertSame([1200, 630], array_slice(getimagesize(public_path('images/og-image.jpg')), 0, 2));
    }
}
