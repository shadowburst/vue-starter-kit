import { PropsOf } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Component, h } from 'vue';

export function useLayout<T extends Component>(layout: T, props: PropsOf<T>) {
    return h(layout, props, usePage);
}
