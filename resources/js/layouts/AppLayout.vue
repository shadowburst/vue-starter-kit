<script setup lang="ts">
import { useLayout } from '@/composables/useLayout';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

const breadcrumbs = defineModel<BreadcrumbItemType[]>('breadcrumbs', {
    default: () => [],
});

useLayout((data: { breadcrumbs?: BreadcrumbItemType[] }) => {
    breadcrumbs.value = data.breadcrumbs ?? [];
});
</script>

<template>
    <AppLayout :breadcrumbs>
        <slot />
    </AppLayout>
</template>
