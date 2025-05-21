/**
 * Ensures the value is always returned as an array.
 * If the input is already an array, it returns a copy of the array.
 * If the input is null or undefined, it returns an empty array.
 * Otherwise, it wraps the input in an array.
 */
export function wrap<T>(value: T | T[]): T[] {
    if (Array.isArray(value)) {
        return [...value];
    }

    if (value == null) {
        return [];
    }

    return [value];
}
