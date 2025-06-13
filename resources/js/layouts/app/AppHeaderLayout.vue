<script setup lang="ts">
import AppShell from '@/components/app/AppShell.vue';
import AppHeader from '@/components/app/header/AppHeader.vue';
import type { BreadcrumbItemType } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItemType[];
};
const { breadcrumbs = [] } = defineProps<Props>();
</script>

<template>
    <div class="flex min-h-screen w-full flex-col">
        <AppHeader :breadcrumbs />
        <AppShell>
            <main class="mx-auto flex size-full max-w-7xl flex-1 flex-col gap-4 rounded-xl">
                <slot />
            </main>
        </AppShell>
    </div>
</template>
