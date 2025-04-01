import { useMediaQuery } from '@vueuse/core';

const isDesktop = useMediaQuery('(min-width: 640px)');
export function useIsDesktop() {
    return isDesktop;
}
