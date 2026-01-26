import { usePageForm } from '@/composables/form';
import { TeamFormRequest, TeamResource } from '@/types';
import { UrlMethodPair } from '@inertiajs/core';

export function useTeamForm(urlMethodPair: UrlMethodPair | (() => UrlMethodPair), team?: TeamResource) {
    const form = usePageForm(urlMethodPair, {
        logo: team?.logo,
        name: team?.name ?? '',
        settings: team?.settings ?? {},
    });

    form.transform(transformTeamForm);

    return form;
}

export type TeamForm = ReturnType<typeof useTeamForm>;
export type TeamFormData = ReturnType<TeamForm['data']>;

export function transformTeamForm(data: TeamFormData): TeamFormRequest {
    return {
        ...data,
        logo: data.logo?.uuid,
    };
}
