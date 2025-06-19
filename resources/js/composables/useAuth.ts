import { usePage } from '@inertiajs/vue3';
import { toReactive } from '@vueuse/core';
import { computed } from 'vue';

export function useAuth() {
    const page = usePage();

    if (!page.props.auth) {
        throw new Error('`useAuth` must be used when a user is logged in');
    }

    const user = computed(() => page.props.auth!.user);
    const abilities = computed(() => page.props.auth!.abilities);
    const team = computed(() => user.value.teams!.find(({ id }) => id === user.value.team_id)!);

    return {
        user: toReactive(user),
        abilities: toReactive(abilities),
        team: toReactive(team),
    };
}
