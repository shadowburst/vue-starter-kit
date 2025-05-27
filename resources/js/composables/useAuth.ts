import { usePage } from '@inertiajs/vue3';
import { reactiveComputed } from '@vueuse/core';

export function useAuth() {
    return reactiveComputed(() => {
        const auth = usePage().props.auth;

        if (!auth) {
            throw new Error('`useAuth` must be used when a user is logged in');
        }
        return auth;
    });
}
