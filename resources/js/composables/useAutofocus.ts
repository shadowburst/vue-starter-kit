import { router } from '@inertiajs/vue3';
import { onUnmounted } from 'vue';

export function useAutofocus() {
    onUnmounted(
        router.on('navigate', () => {
            document.querySelector<HTMLElement>('[autofocus]')?.focus();
        }),
    );
}
