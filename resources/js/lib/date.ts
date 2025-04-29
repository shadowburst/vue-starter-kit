import { DateValue, getLocalTimeZone, parseDate } from '@internationalized/date';
import { useDateFormatter } from 'reka-ui';

export function parse(value: string) {
    return parseDate(value);
}

export function format(value: DateValue | string): string {
    const date = typeof value === 'string' ? parse(value) : value;
    const formatter = useDateFormatter('fr');
    return formatter.custom(date.toDate(getLocalTimeZone()), { dateStyle: 'long' });
}
