<script setup lang="ts">
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import { useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import { BannerAdminEditProps } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
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

const props = defineProps<BannerAdminEditProps>();
const form = useForm({});

function submit() {}
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
            <SectionContent> </SectionContent>
            <SectionFooter>
                <FormSubmitButton />
            </SectionFooter>
        </Section>
    </Form>
</template>
