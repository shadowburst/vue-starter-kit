<script setup lang="ts">
import AppHeader from '@/components/app/shell/header/AppHeader.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};
const { breadcrumbs = [] } = defineProps<Props>();
</script>

<template>
    <div class="flex min-h-screen w-full flex-col">
        <AppHeader :breadcrumbs />
        <main class="mx-auto flex size-full max-w-7xl flex-1 flex-col gap-4 rounded-xl">
            <slot />
        </main>
    </div>
</template>
