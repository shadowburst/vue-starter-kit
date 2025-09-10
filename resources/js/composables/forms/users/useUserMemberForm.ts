import { useComputedForm } from '@/composables';
import { UserMemberFormRequest, UserResource } from '@/types';

export function useUserMemberForm(user?: UserResource) {
    const form = useComputedForm({
        id: user?.id,
        first_name: user?.first_name ?? '',
        last_name: user?.last_name ?? '',
        email: user?.email ?? '',
        phone: user?.phone,
        password: '',
        password_confirmation: '',
        avatar: user?.avatar,
        team_roles: user?.team_roles ?? [],
        team_permissions: user?.team_permissions ?? [],
    });

    form.transform(transformUserMemberForm);

    return form;
}

export type UserMemberForm = ReturnType<typeof useUserMemberForm>;
export type UserMemberFormData = ReturnType<UserMemberForm['data']>;

export function transformUserMemberForm(data: UserMemberFormData): UserMemberFormRequest {
    return {
        ...data,
        avatar: data.avatar?.uuid,
        password: !data.password ? undefined : data.password,
        password_confirmation: !data.password_confirmation ? undefined : data.password_confirmation,
    };
}
