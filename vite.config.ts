import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import i18n from 'laravel-vue-i18n/vite';
import { resolve } from 'node:path';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { defineConfig } from 'vite';
import { watch } from 'vite-plugin-watch';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
        watch({
            pattern: 'app/{Data,Enums}/**/*.php',
            command: 'php artisan typescript:transform -q',
        }),
        watch({
            pattern: 'database/migrations/*.php',
            command: ['php artisan ide-helper:models -q -R -W', 'vendor/bin/pint -q app/Models'],
        }),
        watch({
            pattern: 'routes/**/*.php',
            command: 'php artisan ziggy:generate -q --types',
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },
});
