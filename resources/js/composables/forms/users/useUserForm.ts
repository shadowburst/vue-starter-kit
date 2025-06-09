import { useComputedForm } from '@/composables';
import { UserFormRequest, UserFormResource } from '@/types';

export function useUserForm(user?: UserFormResource) {
    const form = useComputedForm({
        first_name: user?.first_name ?? '',
        last_name: user?.last_name ?? '',
        email: user?.email ?? '',
        phone: user?.phone,
        password: '',
        password_confirmation: '',
    });

    form.transform(transformUserForm);

    return form;
}

export type UserForm = ReturnType<typeof useUserForm>;
export type UserFormData = ReturnType<UserForm['data']>;

export function transformUserForm(data: UserFormData): UserFormRequest {
    return {
        ...data,
        password: !data.password ? undefined : data.password,
        password_confirmation: !data.password_confirmation ? undefined : data.password_confirmation,
    };
}
