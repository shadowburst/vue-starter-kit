<script setup lang="ts">
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Skeleton } from '@/components/ui/skeleton';
import { useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AdminLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.admin.title'),
                href: route('admin.index'),
            },
        ],
    })),
});
</script>

<template>
    <Head :title="trans('pages.admin.title')" />

    <Section>
        <SectionContent>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border"
                >
                    <Skeleton class="size-full" />
                </div>
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border"
                >
                    <Skeleton class="size-full" />
                </div>
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border"
                >
                    <Skeleton class="size-full" />
                </div>
            </div>
        </SectionContent>
    </Section>
</template>
