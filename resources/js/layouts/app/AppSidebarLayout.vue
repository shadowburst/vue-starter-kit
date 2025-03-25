<script setup lang="ts">
import Breadcrumbs from '@/components/app/shell/Breadcrumbs.vue';
import AppSidebar from '@/components/app/shell/sidebar/AppSidebar.vue';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem, NavItem } from '@/types';
import { useLocalStorage } from '@vueuse/core';
import { LayoutGridIcon } from 'lucide-vue-next';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};
const { breadcrumbs = [] } = defineProps<Props>();

const sidebarOpen = useLocalStorage<boolean>('sidebar', true);
function onSidebarOpenChange(open: boolean) {
    sidebarOpen.value = open;
}

const items: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('home'),
        icon: LayoutGridIcon,
        isActive: route().current('home'),
    },
];
</script>

<template>
    <SidebarProvider :default-open="sidebarOpen" :open="sidebarOpen" @update:open="onSidebarOpenChange">
        <AppSidebar :items />
        <SidebarInset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12 md:px-4"
            >
                <div class="flex items-center gap-2">
                    <SidebarTrigger class="-ml-1" />
                    <Breadcrumbs v-if="breadcrumbs.length > 0" :breadcrumbs />
                </div>
            </header>
            <slot />
        </SidebarInset>
    </SidebarProvider>
</template>
