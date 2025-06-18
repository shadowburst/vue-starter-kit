<script setup lang="ts">
import BannerAdminForm from '@/components/banner/admin/BannerAdminForm.vue';
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import { useBannerAdminForm, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
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

function submit() {
    form.post(route('admin.banners.store'));
}
</script>

<template>
    <Head :title="$t('pages.banners.admin.create.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.banners.admin.create.title') }}
                </SectionTitle>
            </SectionHeader>
            <SectionContent class="sm:flex">
                <BannerAdminForm autofocus />
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton />
            </SectionFooter>
        </Section>
    </Form>
</template>
