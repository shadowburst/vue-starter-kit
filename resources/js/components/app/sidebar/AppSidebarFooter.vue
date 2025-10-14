<script setup lang="ts">
import AppUserDropdownMenuContent from '@/components/app/AppUserDropdownMenuContent.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarFooter, SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { UserAvatar } from '@/components/user';
import { useAuth } from '@/composables';
import { ChevronsUpDownIcon } from 'lucide-vue-next';

const { isMobile, state } = useSidebar();
const { user } = useAuth();
</script>

<template>
    <SidebarFooter>
        <SidebarMenu>
            <SidebarMenuItem>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <SidebarMenuButton
                            class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                            size="lg"
                        >
                            <UserAvatar :user />
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-medium">{{ user.full_name }}</span>
                            </div>
                            <ChevronsUpDownIcon class="ml-auto" />
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'"
                        align="end"
                        :side-offset="4"
                    >
                        <AppUserDropdownMenuContent />
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarFooter>
</template>
