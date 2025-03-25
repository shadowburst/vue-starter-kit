import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useAuth() {
    return computed((): SharedData['auth'] => usePage<SharedData>().props.auth);
}
