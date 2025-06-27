<script setup lang="ts">
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarContent,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { clearSessionFilters } from '@/composables';
import type { NavItem } from '@/types';
import { computed } from 'vue';

type Props = {
    items: NavItem[];
};
defineProps<Props>();

const { isMobile, state } = useSidebar();
const expanded = computed(() => isMobile.value || state.value === 'expanded');
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
                <template v-for="item in items.filter((item) => !item.hidden)" :key="item.title">
                    <component v-if="item.items" :is="expanded ? Collapsible : DropdownMenu">
                        <SidebarMenuItem>
                            <component as-child :is="expanded ? CollapsibleTrigger : DropdownMenuTrigger">
                                <SidebarMenuButton
                                    :is-active="item.items.some((subItem) => subItem.isActive)"
                                    :tooltip="item.title"
                                >
                                    <component :is="item.icon" />
                                    <CapitalizeText>
                                        {{ item.title }}
                                    </CapitalizeText>
                                </SidebarMenuButton>
                            </component>
                            <CollapsibleContent v-if="expanded">
                                <SidebarMenuSub>
                                    <SidebarMenuSubItem
                                        v-for="subItem in item.items.filter((item) => !item.hidden)"
                                        :key="subItem.title"
                                        @click="clearSessionFilters(subItem.href)"
                                    >
                                        <SidebarMenuButton
                                            as-child
                                            :is-active="subItem.isActive"
                                            :tooltip="subItem.title"
                                        >
                                            <InertiaLink :href="subItem.href">
                                                <component :is="subItem.icon" />
                                                <CapitalizeText>
                                                    {{ subItem.title }}
                                                </CapitalizeText>
                                            </InertiaLink>
                                        </SidebarMenuButton>
                                    </SidebarMenuSubItem>
                                </SidebarMenuSub>
                            </CollapsibleContent>
                            <DropdownMenuContent v-else align="start" side="right">
                                <DropdownMenuGroup>
                                    <DropdownMenuLabel>
                                        <CapitalizeText>
                                            {{ item.title }}
                                        </CapitalizeText>
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        v-for="subItem in item.items.filter((item) => !item.hidden)"
                                        :key="subItem.title"
                                        @click="clearSessionFilters(subItem.href)"
                                    >
                                        <InertiaLink :href="subItem.href">
                                            <component :is="subItem.icon" />
                                            <CapitalizeText>
                                                {{ subItem.title }}
                                            </CapitalizeText>
                                        </InertiaLink>
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </SidebarMenuItem>
                    </component>
                    <SidebarMenuItem v-else-if="item.href" @click="clearSessionFilters(item.href)">
                        <SidebarMenuButton as-child :is-active="item.isActive" :tooltip="item.title">
                            <InertiaLink :href="item.href">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                            </InertiaLink>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </template>
            </SidebarMenu>
        </SidebarGroup>
        <slot />
    </SidebarContent>
</template>
