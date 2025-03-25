<script setup lang="ts">
import { Sidebar } from '@/components/ui/sidebar';
import { NavItem } from '@/types';
import AppSidebarContent from './AppSidebarContent.vue';
import AppSidebarFooter from './AppSidebarFooter.vue';
import AppSidebarHeader from './AppSidebarHeader.vue';

type Props = {
    items: NavItem[];
};
defineProps<Props>();
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <AppSidebarHeader />
        <AppSidebarContent :items />
        <AppSidebarFooter />
    </Sidebar>
</template>
