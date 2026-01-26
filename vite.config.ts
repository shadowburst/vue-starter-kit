import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import i18n from 'laravel-vue-i18n/vite';
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
                name: 'typescript transform',
                run: ['php', 'artisan', 'typescript:transform'],
                pattern: ['app/Data/**/*.php', 'app/Enums/**/*.php'],
            },
            {
                name: 'IDE helper ',
                run: ['php', 'artisan', 'ide-helper:models', '-N'],
                pattern: ['app/Models/**/*.php'],
            },
            {
                name: 'generate wayfinder',
                run: ['php', 'artisan', 'wayfinder:generate'],
                pattern: ['app/Enums/**/*.php', 'app/Models/**/*.php', 'routes/**/*.php'],
            },
        ]),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
});
