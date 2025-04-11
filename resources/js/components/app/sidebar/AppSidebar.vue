<script setup lang="ts">
import { Sidebar } from '@/components/ui/sidebar';
import { NavItem } from '@/types';
import AppSidebarContent from './AppSidebarContent.vue';
import AppSidebarFooter from './AppSidebarFooter.vue';
import AppSidebarHeader from './AppSidebarHeader.vue';

type Props = {
    contentLabel: string;
    items: NavItem[];
};
defineProps<Props>();
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <AppSidebarHeader />
        <AppSidebarContent :label="contentLabel" :items />
        <AppSidebarFooter />
    </Sidebar>
</template>
