import { router } from '@inertiajs/vue3';
import { computed, ComputedRef, MaybeRefOrGetter, onUnmounted, ref, toValue } from 'vue';

export function useRouterComputed<T>(value: MaybeRefOrGetter<T>): ComputedRef<T> {
    const cache = ref<T>(toValue(value));

    onUnmounted(
        router.on('navigate', () => {
            cache.value = toValue(value);
        }),
    );

    return computed((): T => cache.value);
}
