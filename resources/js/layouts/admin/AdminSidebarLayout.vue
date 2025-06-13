<script setup lang="ts">
import AppShell from '@/components/app/AppShell.vue';
import AppSidebar from '@/components/app/sidebar/AppSidebar.vue';
import { Breadcrumbs } from '@/components/ui/custom/breadcrumbs';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import { useRouterComputed } from '@/composables';
import type { BreadcrumbItemType, NavItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { LayoutGridIcon, MonitorIcon, TextQuoteIcon } from 'lucide-vue-next';

type Props = {
    breadcrumbs?: BreadcrumbItemType[];
};
const { breadcrumbs = [] } = defineProps<Props>();

const sidebarOpen = usePage().props.sidebarOpen;

const items = useRouterComputed((): NavItem[] => [
    {
        title: trans('layouts.admin.sidebar.items.app'),
        href: route('index'),
        icon: MonitorIcon,
    },
    {
        title: trans('layouts.admin.sidebar.items.index'),
        href: route('admin.index'),
        icon: LayoutGridIcon,
        isActive: route().current('admin.index'),
    },
    {
        title: trans('layouts.admin.sidebar.items.banners'),
        href: route('admin.banners.index'),
        icon: TextQuoteIcon,
        isActive: route().current('admin.banners.*'),
    },
]);
</script>

<template>
    <SidebarProvider :default-open="sidebarOpen">
        <AppSidebar :items />
        <SidebarInset>
            <header
                class="border-sidebar-border/70 bg-background sticky inset-x-0 top-0 z-10 flex h-16 shrink-0 items-center gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:rounded-t-xl md:px-4"
            >
                <div class="flex items-center gap-2">
                    <SidebarTrigger class="-ml-1" />
                    <Breadcrumbs v-if="breadcrumbs.length > 0" :breadcrumbs />
                </div>
            </header>
            <AppShell>
                <slot />
            </AppShell>
        </SidebarInset>
    </SidebarProvider>
</template>
