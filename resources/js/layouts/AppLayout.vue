<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItemType[];
};
const { breadcrumbs = [] } = defineProps<Props>();
</script>

<template>
    <AppLayout :breadcrumbs>
        <slot />
    </AppLayout>
</template>
