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
                title: route().params.banner,
                href: route('admin.banners.edit', { banner: route().params.banner }),
            },
        ],
    })),
});

const props = defineProps<BannerAdminFormProps>();

const form = useBannerAdminForm(props.banner);

function submit() {
    form.put(route('admin.banners.update', { banner: props.banner! }));
}
</script>

<template>
    <Head :title="$t('pages.banners.admin.edit.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.banners.admin.edit.title') }}
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
