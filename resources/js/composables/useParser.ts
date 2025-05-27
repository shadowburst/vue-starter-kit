import { DateValue, fromDate, getLocalTimeZone, toCalendarDate, toCalendarDateTime } from '@internationalized/date';

export function useParser() {
    return {
        toDate(value?: DateValue | string) {
            if (!value) {
                return;
            }
            if (typeof value !== 'string') {
                return toCalendarDate(value);
            }
            const date = fromDate(new Date(value), getLocalTimeZone());
            return toCalendarDate(date);
        },
        toDateTime(value?: DateValue | string) {
            if (!value) {
                return;
            }
            if (typeof value !== 'string') {
                return toCalendarDateTime(value);
            }
            const date = fromDate(new Date(value), getLocalTimeZone());
            return toCalendarDateTime(date);
        },
    };
}
