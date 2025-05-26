import { getLocalTimeZone, type CalendarDate } from '@internationalized/date';
import { injectConfigProviderContext, useDateFormatter } from 'reka-ui';
import { useLocale } from './useLocale';
import { useParser } from './useParser';
export function useFormatter() {
    const parse = useParser();

    const { locale } = useLocale();
    const config = injectConfigProviderContext();

    return {
        date(value?: CalendarDate | string, options: Intl.DateTimeFormatOptions = {}): string {
            try {
                const date = typeof value === 'string' ? parse.toDate(value) : value;
                if (!date) {
                    return '';
                }
                const formatter = useDateFormatter(config.locale?.value ?? locale.value);
                return formatter.custom(date.toDate(getLocalTimeZone()), { dateStyle: 'medium', ...options });
            } catch (error) {
                console.error(error);
                return '';
            }
        },
    };
}
