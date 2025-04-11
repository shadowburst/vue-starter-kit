<script setup lang="ts">
import AppUserDropdown from '@/components/app/AppUserDropdown.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarFooter, SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { useAuth } from '@/composables';
import { NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ChevronsUpDownIcon } from 'lucide-vue-next';

type Props = {
    items: NavItem[];
};
defineProps<Props>();

const { isMobile, state } = useSidebar();
const auth = useAuth();
</script>

<template>
    <SidebarFooter>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.isActive" :tooltip="item.title">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
            <SidebarMenuItem>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <SidebarMenuButton
                            class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                            size="lg"
                        >
                            <UserAvatar class="size-8" :user="auth.user" />
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-medium">{{ auth.user.full_name }}</span>
                            </div>
                            <ChevronsUpDownIcon class="ml-auto size-4" />
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'"
                        align="end"
                        :side-offset="4"
                    >
                        <AppUserDropdown />
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarFooter>
</template>
