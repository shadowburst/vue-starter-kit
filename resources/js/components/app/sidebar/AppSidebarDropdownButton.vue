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
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { urlIsActive } from '@/lib/utils';
import type { NavItemGroup } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type Props = {
    item: NavItemGroup;
};
const props = defineProps<Props>();

const page = usePage();

const activeIndex = computed(() => props.item.items.findIndex((subItem) => urlIsActive(subItem.href, page.url)) ?? -1);

const { isMobile, state } = useSidebar();
const expanded = computed(() => isMobile.value || state.value === 'expanded');
</script>

<template>
    <component v-if="item.items" :is="expanded ? Collapsible : DropdownMenu">
        <SidebarMenuItem>
            <component as-child :is="expanded ? CollapsibleTrigger : DropdownMenuTrigger">
                <SidebarMenuButton :is-active="activeIndex !== -1" :tooltip="item.title">
                    <component :is="item.icon" />
                    <CapitalizeText>
                        {{ item.title }}
                    </CapitalizeText>
                </SidebarMenuButton>
            </component>
            <CollapsibleContent v-if="expanded">
                <SidebarMenuSub>
                    <SidebarMenuSubItem v-for="(subItem, index) in item.items" :key="subItem.title">
                        <SidebarMenuButton as-child :is-active="activeIndex === index" :tooltip="subItem.title">
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
                    <DropdownMenuItem v-for="subItem in item.items" :key="subItem.title">
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
</template>
