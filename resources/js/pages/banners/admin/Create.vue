<script setup lang="ts">
import BannerAdminForm from '@/components/banner/admin/BannerAdminForm.vue';
import { Form, FormActions, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import { useBannerAdminForm, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import { store } from '@/routes/admin/banners';
import { BannerAdminFormProps } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AdminLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.banners.admin.index.title'),
                href: route('admin.banners.index'),
            },
            {
                title: trans('pages.banners.admin.create.title'),
                href: route('admin.banners.create'),
            },
        ],
    })),
});

defineProps<BannerAdminFormProps>();
const form = useBannerAdminForm();
</script>

<template>
    <Head :title="$t('pages.banners.admin.create.title')" />

    <Form :form @submit="form.submit(store())">
        <Section class="sm:max-w-xl">
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.banners.admin.create.title') }}
                </SectionTitle>
            </SectionHeader>
            <SectionContent>
                <BannerAdminForm autofocus />
            </SectionContent>
            <SectionFooter>
                <FormActions>
                    <FormSubmitButton />
                </FormActions>
            </SectionFooter>
        </Section>
    </Form>
</template>
