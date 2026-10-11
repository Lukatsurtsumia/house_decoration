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
