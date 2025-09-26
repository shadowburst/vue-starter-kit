<script setup lang="ts">
import { Sidebar, useSidebar } from '@/components/ui/sidebar';
import { NavItem } from '@/types';
import { router } from '@inertiajs/vue3';
import { onUnmounted, ref, watch } from 'vue';
import AppSidebarContent from './AppSidebarContent.vue';
import AppSidebarFooter from './AppSidebarFooter.vue';
import AppSidebarHeader from './AppSidebarHeader.vue';

type Props = {
    items: NavItem[];
};
defineProps<Props>();

const { toggleSidebar, state, setOpenMobile } = useSidebar();
onUnmounted(router.on('navigate', () => setOpenMobile(false)));

const hovered = ref(false);
const previousState = ref(state.value);
function onMouseEnter() {
    hovered.value = true;
    if (previousState.value === 'collapsed' && state.value === 'collapsed') {
        toggleSidebar();
    }
}
function onMouseLeave() {
    hovered.value = false;
    if (previousState.value === 'collapsed' && state.value === 'expanded') {
        toggleSidebar();
    }
}

watch(state, (value) => {
    if (!hovered.value) {
        previousState.value = value;
    }
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" @mouseenter="onMouseEnter" @mouseleave="onMouseLeave">
        <AppSidebarHeader />
        <AppSidebarContent :items />
        <AppSidebarFooter />
    </Sidebar>
</template>
