import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import prismjs from 'vite-plugin-prismjs';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
        prismjs({
            languages: 'all',
        })
    ],
});
