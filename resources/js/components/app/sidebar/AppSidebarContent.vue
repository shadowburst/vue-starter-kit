<script setup lang="ts">
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    SidebarContent,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { clearSessionFilters } from '@/composables';
import type { NavItem } from '@/types';

type Props = {
    items: NavItem[];
};
defineProps<Props>();
</script>

<template>
    <SidebarContent>
        <SidebarGroup class="px-2 py-0">
            <SidebarGroupLabel>
                <CapitalizeText>
                    {{ $t('platform') }}
                </CapitalizeText>
            </SidebarGroupLabel>
            <SidebarMenu>
                <SidebarMenuItem
                    v-for="item in items.filter((item) => !item.hidden)"
                    :key="item.title"
                    @click="clearSessionFilters(item.href)"
                >
                    <SidebarMenuButton as-child :is-active="item.isActive" :tooltip="item.title">
                        <InertiaLink :href="item.href">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </InertiaLink>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroup>
        <slot />
    </SidebarContent>
</template>
