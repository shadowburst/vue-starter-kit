import { GlobalEventNames } from '@inertiajs/core';
import { router } from '@inertiajs/vue3';
import { computed, ComputedRef, MaybeRefOrGetter, onUnmounted, ref, toValue } from 'vue';

export function useInertiaComputed<T>(
    value: MaybeRefOrGetter<T>,
    event: GlobalEventNames = 'navigate',
): ComputedRef<T> {
    const cache = ref<T>(toValue(value));

    onUnmounted(
        router.on(event, () => {
            cache.value = toValue(value);
        }),
    );

    return computed((): T => cache.value);
}
