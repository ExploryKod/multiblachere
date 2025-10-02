import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css', 
                'resources/js/site.js',
                'resources/css/cp.css',
                'resources/js/cp.js'
            ],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
});
