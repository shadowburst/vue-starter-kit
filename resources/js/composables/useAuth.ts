import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useAuth() {
    return computed((): NonNullable<SharedData['auth']> => {
        const auth = usePage<SharedData>().props.auth;

        if (!auth) {
            throw new Error('`useAuth` must be used when a user is logged in');
        }

        return auth;
    });
}
