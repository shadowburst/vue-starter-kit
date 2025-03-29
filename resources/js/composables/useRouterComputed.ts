import { router } from '@inertiajs/vue3';
import { computed, ComputedGetter, ComputedRef, onUnmounted, ref } from 'vue';

export function useRouterComputed<T>(getter: ComputedGetter<T>): ComputedRef<T> {
    const cache = ref<T>(getter());

    onUnmounted(
        router.on('navigate', () => {
            cache.value = getter();
        }),
    );

    return computed((): T => cache.value);
}
