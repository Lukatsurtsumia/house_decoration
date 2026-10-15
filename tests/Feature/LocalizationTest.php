<?php

namespace Tests\Feature;

use App\Models\Estimate;
use App\Support\Content;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'https://plafondi.com');
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function translations(): array
    {
        return [
            'Russian' => ['ru', 'Натяжные потолки в Тбилиси: цены и монтаж'],
            'English' => ['en', 'Stretch Ceilings in Tbilisi: Prices and Installation'],
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function locales(): array
    {
        return ['Russian' => ['ru'], 'English' => ['en']];
    }

    /**
     * The page with JSON escapes (ა) turned back into letters, so text inside the calculator's
     * and gallery's data attributes is checked too. The language menu is left out: it names every
     * language in its own script on purpose.
     */
    private function visibleText(string $url): string
    {
        $html = $this->get($url)->getContent();
        $html = preg_replace(['#<details data-lang-switcher.*?</details>#s', '#<div data-lang-menu.*?</div>#s'], '', $html);

        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', fn (array $match) => mb_chr(hexdec($match[1])), $html);
    }

    #[DataProvider('translations')]
    public function test_each_language_has_its_own_page(string $locale, string $title): void
    {
        $response = $this->get("/{$locale}");

        $response->assertOk();
        $response->assertSee("<html lang=\"{$locale}\">", false);
        $response->assertSee("<title>{$title} | Plafondi</title>", false);
        $response->assertSee("<link rel=\"canonical\" href=\"https://plafondi.com/{$locale}\">", false);
        $response->assertSee("<input type=\"hidden\" name=\"locale\" value=\"{$locale}\">", false);
    }

    public function test_unknown_languages_are_not_found(): void
    {
        $this->get('/de')->assertNotFound();
    }

    public function test_every_version_names_the_others_for_google(): void
    {
        foreach (['/', '/ru', '/en'] as $url) {
            $response = $this->get($url);

            foreach (['ka' => 'https://plafondi.com/', 'ru' => 'https://plafondi.com/ru', 'en' => 'https://plafondi.com/en', 'x-default' => 'https://plafondi.com/'] as $code => $href) {
                $response->assertSee("<link rel=\"alternate\" hreflang=\"{$code}\" href=\"{$href}\">", false);
            }
        }
    }

    public function test_the_language_menu_links_every_language(): void
    {
        $response = $this->get('/en');

        $response->assertSeeInOrder(['data-lang-switcher', 'ქართული', 'Русский', 'English'], false);

        // The template spreads attributes over several lines.
        $html = preg_replace('/\s+/', ' ', $response->getContent());
        $this->assertStringContainsString('href="https://plafondi.com/ru" hreflang="ru" lang="ru"', $html);
        $this->assertStringContainsString('hreflang="en" lang="en" data-lang-link aria-current="true"', $html);
    }

    #[DataProvider('locales')]
    public function test_no_georgian_text_is_left_on_a_translated_page(string $locale): void
    {
        $this->assertDoesNotMatchRegularExpression('/\p{Georgian}/u', $this->visibleText("/{$locale}"));
    }

    public function test_no_russian_text_appears_on_the_georgian_page(): void
    {
        $this->assertDoesNotMatchRegularExpression('/\p{Cyrillic}/u', $this->visibleText('/'));
    }

    #[DataProvider('locales')]
    public function test_every_text_is_translated(string $locale): void
    {
        $content = Content::get($locale);
        unset($content['locales']);
        $untranslated = [];

        array_walk_recursive($content, function (mixed $value, string|int $key) use (&$untranslated) {
            if (is_string($value) && preg_match('/\p{Georgian}/u', $value)) {
                $untranslated[] = "{$key}: {$value}";
            }
        });

        $this->assertSame([], $untranslated, "Still in Georgian in lang/{$locale}/homepage.php");
    }

    #[DataProvider('locales')]
    public function test_translations_only_use_keys_the_georgian_site_has(string $locale): void
    {
        $check = function (array $translation, array $base, string $path) use (&$check, $locale) {
            foreach ($translation as $key => $value) {
                $this->assertArrayHasKey($key, $base, "lang/{$locale}/homepage.php has an unknown key: {$path}{$key}");

                if (is_array($value)) {
                    $check($value, $base[$key], "{$path}{$key}.");
                }
            }
        };

        $check(require lang_path("{$locale}/homepage.php"), config('homepage'), '');
    }

    #[DataProvider('locales')]
    public function test_prices_stay_the_same_in_every_language(string $locale): void
    {
        $this->assertSame(
            array_column(config('homepage.pricing.finishes'), 'price'),
            array_column(Content::get($locale)['pricing']['finishes'], 'price'),
        );
    }

    public function test_the_estimate_lines_follow_the_language(): void
    {
        $room = ['length' => 4.5, 'width' => 4, 'finish' => 'matte', 'wall' => 'tile', 'extras' => [], 'perimeter' => []];

        $russian = Content::get('ru');
        $estimate = Estimate::fromRooms([$room], $russian['pricing'], $russian['calculator']['labels']);

        $this->assertSame('Полотно и монтаж (Матовый)', $estimate->rooms[0]['lines'][0]['label']);
        $this->assertSame('Крепление к плитке', $estimate->rooms[0]['lines'][1]['label']);
        $this->assertSame(429.0, $estimate->total);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function pdfFonts(): array
    {
        return [
            'Georgian' => ['ka', 'NotoSansGeorgian'],
            'Russian' => ['ru', 'NotoSans-'],
            'English' => ['en', 'NotoSans-'],
        ];
    }

    #[DataProvider('pdfFonts')]
    public function test_the_pdf_is_set_in_a_font_with_the_language_letters(string $locale, string $font): void
    {
        $response = $this->post(route('estimate.pdf'), [
            'locale' => $locale,
            'rooms' => json_encode([['length' => 4.5, 'width' => 4, 'finish' => 'matte', 'wall' => 'tile', 'extras' => ['lights' => 2], 'perimeter' => []]]),
        ]);

        $response->assertOk();
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString($font, $response->getContent());
    }

    public function test_the_pdf_rejects_unknown_languages(): void
    {
        $this->post(route('estimate.pdf'), [
            'locale' => 'de',
            'rooms' => json_encode([['length' => 4, 'width' => 4, 'finish' => 'matte']]),
        ])->assertSessionHasErrors('locale');
    }

    public function test_the_sitemap_lists_every_language_with_its_alternates(): void
    {
        $xml = simplexml_load_string($this->get('/sitemap.xml')->getContent());

        $this->assertSame(
            ['https://plafondi.com/', 'https://plafondi.com/ru', 'https://plafondi.com/en'],
            array_map(fn ($url) => (string) $url->loc, iterator_to_array($xml->url, false)),
        );
        $this->assertCount(4, $xml->url[1]->children('xhtml', true));
    }

    public function test_llms_txt_covers_every_language(): void
    {
        $response = $this->get('/llms.txt');

        $response->assertSeeInOrder(['## ქართული', '## Русский', '## English'], false);
        $response->assertSee('#### Сколько стоит натяжной потолок?', false);
        $response->assertSee('- Matte: 21 ₾ / m²', false);
    }
}
