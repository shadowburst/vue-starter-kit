import { fromDate, getLocalTimeZone, toCalendarDate, toCalendarDateTime } from '@internationalized/date';

export function useParser() {
    return {
        toDate(value?: string) {
            if (!value) {
                return;
            }
            const date = fromDate(new Date(value), getLocalTimeZone());
            return toCalendarDate(date);
        },
        toDateTime(value?: string) {
            if (!value) {
                return;
            }
            const date = fromDate(new Date(value), getLocalTimeZone());
            return toCalendarDateTime(date);
        },
    };
}
