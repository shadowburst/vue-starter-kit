import { useColorMode } from '@vueuse/core';

export function useAppearance() {
    useColorMode({ initialValue: 'light' });
}
