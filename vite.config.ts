import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import i18n from 'laravel-vue-i18n/vite';
import { resolve } from 'node:path';
import path from 'path';
import { defineConfig } from 'vite';
import { run } from 'vite-plugin-run';

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
        tailwindcss(),
        run([
            {
                name: 'generate typescript types',
                run: ['php', 'artisan', 'typescript:transform'],
                pattern: ['app/Data/**/*.php', 'app/Enums/**/*.php'],
            },
            {
                name: 'generate ide helper',
                run: ['php', 'artisan', 'ide-helper:models', '-RW'],
                pattern: ['database/migrations/**/*.php'],
            },
            {
                name: 'format ide helper',
                run: ['php', 'vendor/bin/pint', 'app/Models'],
                pattern: ['database/migrations/**/*.php'],
                delay: 100,
            },
            {
                name: 'generate ziggy',
                run: ['php', 'artisan', 'ziggy:generate', '--types'],
                pattern: ['routes/**/*.php'],
            },
        ]),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
});
