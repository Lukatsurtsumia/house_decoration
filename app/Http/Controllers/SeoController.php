<?php

namespace App\Http\Controllers;

use App\Support\Content;
use App\Support\Faq;
use Illuminate\Http\Response;

/**
 * robots.txt, sitemap.xml and llms.txt, built from APP_URL so they always name the live domain.
 */
class SeoController extends Controller
{
    public function robots(): Response
    {
        $sitemap = rtrim(config('app.url'), '/').'/sitemap.xml';

        return response("User-agent: *\nAllow: /\n\nSitemap: {$sitemap}\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * A plain summary for AI assistants (the llms.txt convention): what we do, where, prices and
     * the FAQ in every language of the site, written from the same content as the pages.
     */
    public function llms(): Response
    {
        $locales = Content::locales();
        $brand = config('homepage.brand.name');

        $text = collect([
            "# {$brand}",
            '',
            '> Stretch ceilings (გასაჭიმი ჭერი, натяжные потолки) installed in Tbilisi, Mtskheta and Rustavi, Georgia. The site is in Georgian, Russian and English:',
            '',
            ...array_map(fn (string $code) => "- {$locales[$code]['name']}: ".Content::url($code), array_keys($locales)),
            ...collect(array_keys($locales))->flatMap(fn (string $code) => ['', ...$this->summary($code)]),
        ])->implode("\n");

        return response($text."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * One language's section of llms.txt.
     *
     * @return array<int, string>
     */
    private function summary(string $locale): array
    {
        $content = Content::get($locale);
        $pricing = $content['pricing'];
        $currency = $pricing['currency'];
        $contact = $content['contact'];
        $headings = $content['llms'];
        $line = fn (array $item, string $prefix = '') => "- {$item['name']}: {$prefix}{$item['price']} {$currency}".(isset($item['unit']) ? " / {$item['unit']}" : '');
        // array_values: price lists are keyed ("matte", "tile"…), and keyed lines from one language
        // would overwrite the same keys from another when the sections are merged.
        $lines = fn (array $items, string $prefix = '') => array_values(array_map(fn (array $item) => $line($item, $prefix), $items));

        return [
            "## {$content['locales'][$locale]['name']}",
            '',
            "{$content['brand']['tagline']}. {$content['hero']['description']}",
            '',
            "### {$headings['prices']}",
            ...$lines($pricing['finishes']),
            $line($pricing['minimum']),
            ...$lines(array_filter($pricing['walls'], fn (array $wall) => $wall['price'] > 0), '+'),
            ...$lines($pricing['extras']),
            ...$lines($pricing['perimeter']),
            '',
            "### {$headings['area']}",
            "{$content['area']['title']}. {$content['area']['description']}",
            '',
            "### {$headings['contact']}",
            "- {$headings['website']}: ".Content::url($locale),
            // Made-up contact details are left out until the real ones are in config.
            ...(($contact['placeholder'] ?? false) ? [] : [
                "- {$contact['labels']['phone']}: {$contact['phone']}",
                "- {$contact['labels']['email']}: {$contact['email']}",
            ]),
            "- {$contact['labels']['hours']}: {$contact['hours']}",
            '',
            "### {$headings['faq']}",
            ...collect(Faq::items($content))->flatMap(fn (array $item) => ['', "#### {$item['question']}", $item['answer']]),
        ];
    }

    /**
     * The site is one page in three languages; each URL names the others, and our project
     * photos are listed so they can show up in image search.
     */
    public function sitemap(): Response
    {
        $alternates = array_map(fn (string $code) => ['hreflang' => $code, 'href' => Content::url($code)], array_keys(Content::locales()));

        $images = array_map(
            fn (string $name) => asset("images/projects/{$name}.webp"),
            array_keys(config('homepage.photos')),
        );

        return response()
            ->view('sitemap', [
                'pages' => array_column($alternates, 'href'),
                'alternates' => $alternates,
                'default' => Content::url(Content::defaultLocale()),
                'images' => $images,
            ])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
