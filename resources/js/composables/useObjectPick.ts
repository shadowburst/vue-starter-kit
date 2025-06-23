import { computed, ComputedRef } from 'vue';

export function useObjectPick<T extends Record<string, any>, K extends keyof T>(
    obj: T,
    ...keys: K[]
): ComputedRef<Pick<T, K>> {
    return computed(
        () =>
            Object.entries(obj).reduce(
                (carry, [k, value]) => {
                    const key = k as K;

                    if (!keys.includes(key)) {
                        return carry;
                    }

                    return Object.assign(carry, { [key]: value });
                },
                {} as Partial<Pick<T, K>>,
            ) as Pick<T, K>,
    );
}
