<script setup lang="ts">
import { Capitalize } from '@/components/typography';
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

type Props = {
    label: string;
    items: NavItem[];
};
defineProps<Props>();
</script>

<template>
    <SidebarContent>
        <SidebarGroup class="px-2 py-0">
            <SidebarGroupLabel>
                <Capitalize>
                    {{ label }}
                </Capitalize>
            </SidebarGroupLabel>
            <SidebarMenu>
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton as-child :is-active="item.isActive" :tooltip="item.title">
                        <Link :href="item.href">
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
