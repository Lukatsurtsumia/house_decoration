import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Noto Sans Georgian', {
                    weights: [400, 500, 600, 700],
                    subsets: ['georgian'],
                }),
                bunny('Noto Serif Georgian', {
                    weights: [500, 600],
                    subsets: ['georgian'],
                }),
                // Latin and Cyrillic for the Russian and English pages, and for digits and the
                // "Plafondi" wordmark everywhere. Not preloaded: thanks to unicode-range a browser
                // only downloads the files whose letters the page actually uses.
                bunny('Noto Sans', {
                    weights: [400, 500, 600, 700],
                    subsets: ['latin', 'cyrillic'],
                    preload: false,
                }),
                bunny('Noto Serif', {
                    weights: [500, 600],
                    subsets: ['latin', 'cyrillic'],
                    preload: false,
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
