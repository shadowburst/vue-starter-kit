<script setup lang="ts">
import AppBreadcrumbs from '@/components/app/AppBreadcrumbs.vue';
import AppShell from '@/components/app/AppShell.vue';
import AppSidebar from '@/components/app/sidebar/AppSidebar.vue';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import { useRouterComputed } from '@/composables';
import type { BreadcrumbItem, NavItem, SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { LayoutGridIcon } from 'lucide-vue-next';
import { Slot } from 'reka-ui';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};
const { breadcrumbs = [] } = defineProps<Props>();

const sidebarOpen = usePage<SharedData>().props.sidebarOpen;

const items = useRouterComputed((): NavItem[] => [
    {
        title: trans('layouts.admin.sidebar.items.home'),
        href: route('admin.home'),
        icon: LayoutGridIcon,
        isActive: route().current('admin.home'),
    },
]);
</script>

<template>
    <SidebarProvider :default-open="sidebarOpen">
        <AppSidebar :content-label="$t('backend')" :items />
        <SidebarInset>
            <header
                class="border-sidebar-border/70 flex h-16 shrink-0 items-center gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
            >
                <div class="flex items-center gap-2">
                    <SidebarTrigger class="-ml-1" />
                    <AppBreadcrumbs v-if="breadcrumbs.length > 0" :breadcrumbs />
                </div>
            </header>
            <AppShell>
                <Slot class="px-4 py-6">
                    <slot />
                </Slot>
            </AppShell>
        </SidebarInset>
    </SidebarProvider>
</template>
