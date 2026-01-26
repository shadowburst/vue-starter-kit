import { router, usePage } from '@inertiajs/vue3';
import { get } from 'lodash-es';
import { computed, ComputedRef, MaybeRefOrGetter, ref, toValue } from 'vue';

export function usePageProp<T>(data: MaybeRefOrGetter<string>): ComputedRef<T | undefined>;
export function usePageProp<T>(data: MaybeRefOrGetter<string>, defaultValue: T): ComputedRef<NonNullable<T>>;
export function usePageProp<T>(data: MaybeRefOrGetter<string>, defaultValue?: T) {
    const page = usePage();

    const reloaded = ref(false);

    return computed((): T | undefined => {
        const dataKey = toValue(data);

        const result = get(page.props, dataKey) as T | undefined;

        if (result != undefined) {
            return result as T;
        }

        router.reload({
            only: [dataKey],
            onFinish: () => {
                reloaded.value = true;
            },
        });

        return defaultValue;
    });
}
