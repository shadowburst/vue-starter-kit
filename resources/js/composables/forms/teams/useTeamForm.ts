import { useComputedForm } from '@/composables';
import { TeamFormRequest, TeamResource } from '@/types';

export function useTeamForm(team?: TeamResource) {
    const form = useComputedForm({
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
