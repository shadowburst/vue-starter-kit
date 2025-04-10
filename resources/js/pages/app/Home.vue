<script setup lang="ts">
import { Skeleton } from '@/components/ui/skeleton';
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
        <div
            class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-screen flex-1 rounded-xl border md:min-h-min"
        >
            <Skeleton class="size-full" />
        </div>
    </div>
</template>
