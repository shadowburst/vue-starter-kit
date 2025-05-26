<script setup lang="ts">
import { Section, SectionContent, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import { useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import { BannerAdminCreateProps } from '@/types';
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

const props = defineProps<BannerAdminCreateProps>();
</script>

<template>
    <Head :title="$t('pages.banners.admin.create.title')" />

    <Section>
        <SectionHeader>
            <SectionTitle>
                {{ $t('pages.banners.admin.create.title') }}
            </SectionTitle>
        </SectionHeader>
        <SectionContent> </SectionContent>
    </Section>
</template>
