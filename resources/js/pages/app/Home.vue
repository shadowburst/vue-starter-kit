<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { useLayout } from '@/composables';
import { AppLayout } from '@/layouts';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(AppLayout, {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: route('home'),
            },
        ] as BreadcrumbItem[],
    }),
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
        </div>
        <div
            class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min"
        >
            <PlaceholderPattern />
        </div>
    </div>
</template>
