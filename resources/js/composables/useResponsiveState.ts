import { useMediaQuery } from '@vueuse/core';
import { computed } from 'vue';

export function useResponsiveState() {
    const isDesktop = useMediaQuery('(min-width: 640px)');
    const isMobile = computed(() => !isDesktop.value);

    return { isDesktop, isMobile };
}
