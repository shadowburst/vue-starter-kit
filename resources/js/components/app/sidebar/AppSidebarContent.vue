<script setup lang="ts">
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    SidebarContent,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import type { NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { useSessionStorage } from '@vueuse/core';

type Props = {
    label: string;
    items: NavItem[];
};
defineProps<Props>();

function clearSessionStorage(href: string) {
    const remembered = useSessionStorage(href, {});
    remembered.value = undefined;
}
</script>

<template>
    <SidebarContent>
        <SidebarGroup class="px-2 py-0">
            <SidebarGroupLabel>
                <CapitalizeText>
                    {{ label }}
                </CapitalizeText>
            </SidebarGroupLabel>
            <SidebarMenu>
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton as-child :is-active="item.isActive" :tooltip="item.title">
                        <Link :href="item.href" @click="clearSessionStorage(item.href)">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroup>
        <slot />
    </SidebarContent>
</template>
