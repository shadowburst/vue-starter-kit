import { DateValue, getLocalTimeZone } from '@internationalized/date';
import { useDateFormatter } from 'reka-ui';
import { useLocale } from './useLocale';
import { useParser } from './useParser';

export function useFormatter() {
    const parse = useParser();

    const { locale } = useLocale();

    return {
        date(value?: DateValue | string | number, options?: Intl.DateTimeFormatOptions): string {
            try {
                const date = parse.toDate(value);
                if (!date) {
                    return '';
                }
                const formatter = useDateFormatter(locale.value);
                return formatter.custom(date.toDate(getLocalTimeZone()), options ?? { dateStyle: 'medium' });
            } catch (error) {
                console.error(error);
                return '';
            }
        },
        timestamp(value?: DateValue | string | number): number {
            try {
                const date = parse.toDateTime(value);
                return date?.toDate(getLocalTimeZone()).getTime() ?? 0;
            } catch (error) {
                console.error(error);
                return 0;
            }
        },
    };
}
