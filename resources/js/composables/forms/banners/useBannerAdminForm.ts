import { useComputedForm } from '@/composables';
import { BannerAdminFormRequest, BannerAdminFormResource } from '@/types';

export function useBannerAdminForm(banner?: BannerAdminFormResource) {
    const form = useComputedForm({
        name: banner?.name ?? '',
        message: banner?.message ?? '',
        action: banner?.action,
        start_date: banner?.start_date ?? '',
        end_date: banner?.end_date ?? '',
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
