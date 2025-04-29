import { useDateFormatter } from 'reka-ui';

export function parse(value: string) {
    return new Date(value);
}

export function format(value: Date | string, locale: string): string {
    const date = typeof value === 'string' ? parse(value) : value;
    const formatter = useDateFormatter(locale);
    return formatter.custom(date, { dateStyle: 'long' });
}
