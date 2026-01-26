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
import { urlIsActive } from '@/lib/utils';
import type { NavItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import AppSidebarDropdownButton from './AppSidebarDropdownButton.vue';

type Props = {
    items: NavItem[];
};
defineProps<Props>();

const page = usePage();
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
                <template v-for="item in items" :key="item.title">
                    <AppSidebarDropdownButton v-if="item.items" :item="item" />
                    <SidebarMenuItem v-else-if="item.href">
                        <SidebarMenuButton as-child :is-active="urlIsActive(item.href, page.url)" :tooltip="item.title">
                            <InertiaLink :href="item.href">
                                <component :is="item.icon" />
                                <CapitalizeText>{{ item.title }}</CapitalizeText>
                            </InertiaLink>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </template>
            </SidebarMenu>
        </SidebarGroup>
        <slot />
    </SidebarContent>
</template>
