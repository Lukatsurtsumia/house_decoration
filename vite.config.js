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
                // Latin letters and digits in serif text, e.g. the "Plafond" wordmark and prices.
                bunny('Noto Serif', {
                    weights: [500, 600],
                    subsets: ['latin'],
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
