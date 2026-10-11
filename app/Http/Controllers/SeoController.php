<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * robots.txt and sitemap.xml, built from APP_URL so they always name the live domain.
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
     * the FAQ, written from the same config as the page.
     */
    public function llms(): Response
    {
        $content = config('homepage');
        $pricing = $content['pricing'];
        $currency = $pricing['currency'];
        $contact = $content['contact'];
        $line = fn (array $item, string $prefix = '') => "- {$item['name']}: {$prefix}{$item['price']} {$currency}".(isset($item['unit']) ? " / {$item['unit']}" : '');

        $text = collect([
            "# {$content['brand']['name']}",
            '',
            "> {$content['brand']['tagline']}. Stretch ceilings (გასაჭიმი ჭერი) installed in Tbilisi, Mtskheta and Rustavi, Georgia.",
            '',
            $content['hero']['description'],
            '',
            '## ფასები (GEL)',
            ...array_map($line, $pricing['finishes']),
            $line($pricing['minimum']),
            ...array_map(fn (array $item) => $line($item, '+'), array_filter($pricing['walls'], fn (array $wall) => $wall['price'] > 0)),
            ...array_map($line, $pricing['extras']),
            ...array_map($line, $pricing['perimeter']),
            '',
            '## მომსახურების არეალი',
            "{$content['area']['title']}. {$content['area']['description']}",
            '',
            '## კონტაქტი',
            "- ვებგვერდი: ".rtrim(config('app.url'), '/').'/',
            // Made-up contact details are left out until the real ones are in config.
            ...(($contact['placeholder'] ?? false) ? [] : [
                "- {$contact['labels']['phone']}: {$contact['phone']}",
                "- {$contact['labels']['email']}: {$contact['email']}",
            ]),
            "- {$contact['labels']['hours']}: {$contact['hours']}",
            '',
            '## ხშირად დასმული კითხვები',
            ...collect(\App\Support\Faq::items($content))->flatMap(fn (array $item) => ['', "### {$item['question']}", $item['answer']]),
        ])->implode("\n");

        return response($text."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * The site is a single page; listing our project photos lets them show up in image search.
     */
    public function sitemap(): Response
    {
        $images = array_map(
            fn (string $name) => asset("images/projects/{$name}.webp"),
            array_keys(config('homepage.photos')),
        );

        return response()
            ->view('sitemap', [
                'home' => rtrim(config('app.url'), '/').'/',
                'images' => $images,
            ])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
