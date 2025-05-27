import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const LOCALE_COOKIE_NAME = 'locale';
const LOCALE_COOKIE_MAX_AGE = 60 * 60 * 24 * 365; // 1 year in seconds
const locales = ['fr'] as const;
type Locale = (typeof locales)[number];
const fallbackLocale: Locale = 'fr';

export function useLocale() {
    const locale = ref<Locale>(usePage().props.locale as Locale);

    function setLocale(newLocale: Locale) {
        locale.value = newLocale;
        document.cookie = `${LOCALE_COOKIE_NAME}=${locale.value}; path=/; max-age=${LOCALE_COOKIE_MAX_AGE}`;
    }

    return {
        locale,
        locales: ref(locales),
        setLocale,
        fallbackLocale: ref(fallbackLocale),
    };
}
