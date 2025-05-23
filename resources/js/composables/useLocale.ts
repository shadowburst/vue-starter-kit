import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const LOCALE_COOKIE_NAME = 'locale';
const locales = ['fr'] as const;
type Locale = (typeof locales)[number];
const fallbackLocale: Locale = 'fr';

export function useLocale() {
    const locale = ref<Locale>(usePage().props.locale as Locale);

    function setLocale(newLocale: Locale) {
        locale.value = newLocale;
        document.cookie = `${LOCALE_COOKIE_NAME}=${locale.value}; path=/; max-age=${60 * 60 * 24 * 7}`;
    }

    return {
        locale,
        locales: ref(locales),
        setLocale,
        fallbackLocale: ref(fallbackLocale),
    };
}
