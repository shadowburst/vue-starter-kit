<script setup lang="ts">
import { Sidebar } from '@/components/ui/sidebar';
import { NavItem } from '@/types';
import AppSidebarContent from './AppSidebarContent.vue';
import AppSidebarFooter from './AppSidebarFooter.vue';
import AppSidebarHeader from './AppSidebarHeader.vue';

type Props = {
    headerItems?: NavItem[];
    items?: NavItem[];
    footerItems?: NavItem[];
};
const { headerItems = [], items = [], footerItems = [] } = defineProps<Props>();
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <AppSidebarHeader :items="headerItems" />
        <AppSidebarContent :items />
        <AppSidebarFooter :items="footerItems" />
    </Sidebar>
</template>
