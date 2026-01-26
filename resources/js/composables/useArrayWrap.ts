import { Arrayable } from '@vueuse/core';
import { computed, ComputedRef, MaybeRefOrGetter, toValue } from 'vue';

export type UseArrayWrapReturn<T = any> = ComputedRef<NonNullable<T>[]>;

export function useArrayWrap<T = any>(list: MaybeRefOrGetter<Arrayable<T> | undefined>): UseArrayWrapReturn<T> {
    return computed(() => {
        const value = toValue(list);

        if (!value) {
            return [];
        }
        if (!Array.isArray(value)) {
            return [value];
        }
        return [...value.filter((value) => value != undefined)];
    });
}
