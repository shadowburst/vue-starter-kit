import { AppPageProps } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';

type Auth = AppPageProps['auth'];
type UseAuthReturn<TAllowGuest extends boolean> = TAllowGuest extends true
    ? {
          abilities: ComputedRef<Auth['abilities']>;
          team: ComputedRef<Auth['team']>;
          user: ComputedRef<Auth['user']>;
      }
    : {
          abilities: ComputedRef<Auth['abilities']>;
          team: ComputedRef<NonNullable<Auth['team']>>;
          user: ComputedRef<NonNullable<Auth['user']>>;
      };

export function useAuth(allowGuest?: false): UseAuthReturn<false>;
export function useAuth(allowGuest: true): UseAuthReturn<true>;
export function useAuth(allowGuest = false): UseAuthReturn<typeof allowGuest> {
    const page = usePage();

    const abilities = computed(() => page.props.auth.abilities);
    const team = computed(() => {
        const team = page.props.auth.team;
        if (!allowGuest && !team) {
            throw new Error(
                'useAuth() called but no team found. If you want to allow guest users, pass true as an argument to useAuth(true).',
            );
        }
        return team;
    });
    const user = computed(() => {
        const user = page.props.auth.user;
        if (!allowGuest && !user) {
            throw new Error(
                'useAuth() called but no authenticated user found. If you want to allow guest users, pass true as an argument to useAuth(true).',
            );
        }
        return user;
    });

    return {
        abilities,
        team,
        user,
    };
}
