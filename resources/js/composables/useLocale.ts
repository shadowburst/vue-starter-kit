import { useLocalStorage } from '@vueuse/core';

const locales = ['fr'] as const;
type Locale = (typeof locales)[number];
const defaultLocale: Locale = 'fr';

export function useLocale() {
    const browserLocale = navigator.language?.split('-')?.[0] as Locale;
    const initialLocale = locales.includes(browserLocale) ? browserLocale : defaultLocale;
    const locale = useLocalStorage('locale', initialLocale);
    return { locale };
}
