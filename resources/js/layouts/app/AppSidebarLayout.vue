<script setup lang="ts">
import AppBanner from '@/components/app/AppBanner.vue';
import AppShell from '@/components/app/AppShell.vue';
import AppSidebar from '@/components/app/sidebar/AppSidebar.vue';
import { Breadcrumbs } from '@/components/ui/custom/breadcrumbs';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import { useAuth, useRouterComputed } from '@/composables';
import type { BreadcrumbItemType, NavItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { LayoutGridIcon, MonitorCogIcon } from 'lucide-vue-next';

type Props = {
    breadcrumbs?: BreadcrumbItemType[];
};
const { breadcrumbs = [] } = defineProps<Props>();

const sidebarOpen = usePage().props.sidebarOpen;

const { user } = useAuth();

const items = useRouterComputed((): NavItem[] => [
    {
        title: trans('layouts.app.sidebar.items.admin'),
        href: route('admin.index'),
        icon: MonitorCogIcon,
        hidden: !user.is_admin,
    },
    {
        title: trans('layouts.app.sidebar.items.index'),
        href: route('index'),
        icon: LayoutGridIcon,
        isActive: route().current('index'),
    },
]);
</script>

<template>
    <SidebarProvider :default-open="sidebarOpen">
        <AppSidebar :items />
        <SidebarInset>
            <AppBanner class="border-b" />
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
