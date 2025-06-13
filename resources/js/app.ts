import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { useColorMode } from '@vueuse/core';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { i18nVue } from 'laravel-vue-i18n';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        app.use(i18nVue, {
            resolve: async (lang: string) => {
                const langs = import.meta.glob('../../lang/*.json');
                return await langs[`../../lang/${lang}.json`]();
            },
            // Mount here so that translations are available when page loads
            onLoad: () => {
                /* check needed to avoid remounting (which would fail) when we call loadLanguageAsync to change language */
                //@ts-expect-error element added dynamically
                if (el?.__vue_app__) {
                    return;
                }

                app.mount(el);
            },
        });
    },
    progress: {
        color: '--primary',
    },
});

useColorMode({ initialValue: 'light' });
