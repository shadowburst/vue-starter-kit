import { useComputedForm } from '@/composables';
import { BannerAdminFormRequest, BannerResource } from '@/types';

export function useBannerAdminForm(banner?: BannerResource) {
    const form = useComputedForm({
        name: banner?.name ?? '',
        message: banner?.message ?? '',
        action: banner?.action,
        is_enabled: banner?.is_enabled ?? false,
    });

    form.transform(transformBannerAdminForm);

    return form;
}

export type BannerAdminForm = ReturnType<typeof useBannerAdminForm>;
export type BannerAdminFormData = ReturnType<BannerAdminForm['data']>;

export function transformBannerAdminForm(data: BannerAdminFormData): BannerAdminFormRequest {
    return {
        ...data,
    };
}
