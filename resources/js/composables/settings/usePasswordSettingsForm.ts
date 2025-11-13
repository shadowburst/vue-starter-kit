import { useComputedForm } from '@/composables';
import { UpdatePasswordSettingsRequest } from '@/types';

export function usePasswordSettingsForm() {
    const form = useComputedForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    form.transform(transformPasswordSettingsForm);

    return form;
}

export type PasswordSettingsForm = ReturnType<typeof usePasswordSettingsForm>;
export type PasswordSettingsFormData = ReturnType<PasswordSettingsForm['data']>;

export function transformPasswordSettingsForm(data: PasswordSettingsFormData): Partial<UpdatePasswordSettingsRequest> {
    return {
        ...data,
    };
}
