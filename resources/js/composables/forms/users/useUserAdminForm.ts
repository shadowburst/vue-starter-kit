import { useComputedForm } from '@/composables';
import { UserAdminFormRequest, UserAdminFormResource } from '@/types';

export function useUserAdminForm(user?: UserAdminFormResource) {
    const form = useComputedForm({
        first_name: user?.first_name ?? '',
        last_name: user?.last_name ?? '',
        email: user?.email ?? '',
        phone: user?.phone,
        password: '',
        password_confirmation: '',
    });

    form.transform(transformUserAdminForm);

    return form;
}

export type UserAdminForm = ReturnType<typeof useUserAdminForm>;
export type UserAdminFormData = ReturnType<UserAdminForm['data']>;

export function transformUserAdminForm(data: UserAdminFormData): UserAdminFormRequest {
    return {
        ...data,
        password: !data.password ? undefined : data.password,
        password_confirmation: !data.password_confirmation ? undefined : data.password_confirmation,
    };
}
