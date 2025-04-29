import { useLocale } from '@/composables';
import { date as dateLib } from '@/lib';

export function date(value: Date | string) {
    const { locale } = useLocale();
    return dateLib.format(value, locale.value);
}
