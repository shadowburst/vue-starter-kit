<script setup lang="ts">
import { Sidebar, useSidebar } from '@/components/ui/sidebar';
import { NavItem } from '@/types';
import { router } from '@inertiajs/vue3';
import { onUnmounted } from 'vue';
import AppSidebarContent from './AppSidebarContent.vue';
import AppSidebarFooter from './AppSidebarFooter.vue';
import AppSidebarHeader from './AppSidebarHeader.vue';

type Props = {
    contentLabel: string;
    items: NavItem[];
};
defineProps<Props>();

const { setOpenMobile } = useSidebar();
onUnmounted(router.on('navigate', () => setOpenMobile(false)));
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <AppSidebarHeader />
        <AppSidebarContent :label="contentLabel" :items />
        <AppSidebarFooter />
    </Sidebar>
</template>
