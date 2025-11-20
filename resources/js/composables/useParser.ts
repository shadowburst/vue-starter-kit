import { DateValue, fromDate, getLocalTimeZone, toCalendarDate, toCalendarDateTime } from '@internationalized/date';

export function useParser() {
    return {
        toDate(value?: DateValue | string | number) {
            if (!value) {
                return;
            }
            if (typeof value === 'string' || typeof value === 'number') {
                const date = fromDate(new Date(value), getLocalTimeZone());
                return toCalendarDate(date);
            }
            return toCalendarDate(value);
        },
        toDateTime(value?: DateValue | string | number) {
            if (!value) {
                return;
            }
            if (typeof value === 'string' || typeof value === 'number') {
                const date = fromDate(new Date(value), getLocalTimeZone());
                return toCalendarDateTime(date);
            }
            return toCalendarDateTime(value);
        },
    };
}
