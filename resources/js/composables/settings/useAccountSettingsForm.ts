import { useComputedForm } from '@/composables';
import { UpdateAccountSettingsRequest, UserResource } from '@/types';

export function useAccountSettingsForm(user?: UserResource) {
    const form = useComputedForm({
        first_name: user?.first_name ?? '',
        last_name: user?.last_name ?? '',
        email: user?.email ?? '',
        phone: user?.phone,
        avatar: user?.avatar,
    });

    form.transform(transformAccountSettingsForm);

    return form;
}

export type AccountSettingsForm = ReturnType<typeof useAccountSettingsForm>;
export type AccountSettingsFormData = ReturnType<AccountSettingsForm['data']>;

export function transformAccountSettingsForm(data: AccountSettingsFormData): Partial<UpdateAccountSettingsRequest> {
    return {
        ...data,
        avatar: data.avatar?.uuid,
    };
}
