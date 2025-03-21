import { inject, provide } from 'vue';

export function useLayout<T extends object>(props: T | ((data: T) => void)): void {
    type Setter = (data: T) => void;
    if (typeof props === 'function') {
        provide<Setter>('layout', props);
    } else {
        const setter = inject<Setter>('layout');
        if (!setter) {
            throw new Error('useLayout must be used in a Layout');
        }
        setter(props);
    }
}
