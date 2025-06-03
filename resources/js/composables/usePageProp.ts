import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef, MaybeRefOrGetter, toValue } from 'vue';

export function usePageProp<T>(data: MaybeRefOrGetter<string | undefined>): ComputedRef<T | undefined>;
export function usePageProp<T>(
    data: MaybeRefOrGetter<string | undefined>,
    defaultValue: T,
): ComputedRef<NonNullable<T>>;
export function usePageProp<T>(data: MaybeRefOrGetter<string | undefined>, defaultValue?: T) {
    return computed((): T | undefined => {
        const props = usePage().props;

        const dataKey = toValue(data);
        if (!dataKey) {
            return;
        }

        const result = dataKey.split('.').reduce((value: any, key) => value?.[key], props);

        if (!result) {
            return defaultValue;
        }

        return result as T;
    });
}
