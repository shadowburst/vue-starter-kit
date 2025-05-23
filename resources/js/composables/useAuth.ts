import { usePage } from '@inertiajs/vue3';

export function useAuth() {
    const auth = usePage().props.auth;

    if (!auth) {
        throw new Error('`useAuth` must be used when a user is logged in');
    }

    return auth;
}
