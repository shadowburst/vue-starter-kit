import { computed, ComputedRef, MaybeRefOrGetter } from 'vue';

export function useObjectOmit<T extends Record<string, any>, K extends keyof T>(
    obj: MaybeRefOrGetter<T>,
    ...keys: K[]
): ComputedRef<Omit<T, K>> {
    return computed(
        () =>
            Object.entries(obj).reduce(
                (carry, [k, value]) => {
                    const key = k as K;

                    if (keys.includes(key)) {
                        return carry;
                    }

                    return Object.assign(carry, { [key]: value });
                },
                {} as Partial<Omit<T, K>>,
            ) as Omit<T, K>,
    );
}
