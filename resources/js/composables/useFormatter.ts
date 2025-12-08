import { getLocalTimeZone } from '@internationalized/date';
import { useDateFormatter } from 'reka-ui';
import { useLocale } from './useLocale';
import { ParsableDateValue, useParser } from './useParser';

export function useFormatter() {
    const parse = useParser();

    const { locale } = useLocale();

    return {
        date(value?: ParsableDateValue, options?: Intl.DateTimeFormatOptions): string {
            try {
                const date = parse.toDate(value);
                if (!date) {
                    return '';
                }
                const formatter = useDateFormatter(locale.value);
                return formatter.custom(date.toDate(getLocalTimeZone()), options ?? { dateStyle: 'medium' });
            } catch (error) {
                console.warn(error);
                return '';
            }
        },
    };
}
