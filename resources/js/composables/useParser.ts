import {
    CalendarDate,
    CalendarDateTime,
    DateValue,
    fromAbsolute,
    fromDate,
    getLocalTimeZone,
    toCalendarDate,
    toCalendarDateTime,
} from '@internationalized/date';

export type ParsableDateValue = number | string | Date | DateValue;

function toDateTime(value?: ParsableDateValue): CalendarDateTime | undefined {
    if (!value) {
        return;
    }
    if (typeof value === 'number') {
        return toCalendarDateTime(fromAbsolute(value, getLocalTimeZone()));
    }
    if (typeof value === 'string') {
        const date = fromDate(new Date(value), getLocalTimeZone());
        return toCalendarDateTime(date);
    }
    if (value instanceof Date) {
        const date = fromDate(value, getLocalTimeZone());
        return toCalendarDateTime(date);
    }
    return toCalendarDateTime(value);
}

function toDate(value?: ParsableDateValue): CalendarDate | undefined {
    const parsedDateTime = toDateTime(value);
    if (!parsedDateTime) {
        return;
    }
    return toCalendarDate(parsedDateTime);
}

function toTimestamp(value?: ParsableDateValue): number | undefined {
    return toDateTime(value)?.toDate(getLocalTimeZone()).getTime();
}

export function useParser() {
    return {
        toDate,
        toDateTime,
        toTimestamp,
    };
}
