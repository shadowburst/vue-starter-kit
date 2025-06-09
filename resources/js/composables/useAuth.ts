import { usePage } from '@inertiajs/vue3';
import { reactiveComputed } from '@vueuse/core';

export function useAuth() {
    const page = usePage();

    if (!page.props.auth) {
        throw new Error('`useAuth` must be used when a user is logged in');
    }

    const user = reactiveComputed(() => page.props.auth!.user);
    const abilities = reactiveComputed(() => page.props.auth!.abilities);

    return {
        user,
        abilities,
    };
}
