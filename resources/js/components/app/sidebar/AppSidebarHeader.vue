<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { useAuth, useRouterComputed } from '@/composables';
import { NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { ChevronsUpDownIcon, CircleIcon } from 'lucide-vue-next';

const { isMobile, state } = useSidebar();
const { user } = useAuth();

const environments = useRouterComputed((): NavItem[] => [
    {
        title: trans('backend'),
        href: route('admin.home'),
        isActive: route().current('admin.*'),
    },
    {
        title: trans('frontend'),
        href: route('home'),
        isActive: !route().current('admin.*'),
    },
]);
</script>

<template>
    <SidebarHeader>
        <SidebarMenu>
            <SidebarMenuItem>
                <DropdownMenu v-if="user">
                    <DropdownMenuTrigger as-child>
                        <SidebarMenuButton
                            class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                            size="lg"
                        >
                            <AppLogo />
                            <ChevronsUpDownIcon />
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'"
                        align="start"
                        :side-offset="4"
                    >
                        <DropdownMenuLabel as-child>
                            <CapitalizeText>
                                {{ $t('environment') }}
                            </CapitalizeText>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuGroup>
                            <DropdownMenuItem v-for="{ title, href, isActive } in environments" :key="title" as-child>
                                <Link class="block w-full" :href>
                                    <CircleIcon :class="{ 'fill-current': isActive }" />
                                    <CapitalizeText>
                                        {{ title }}
                                    </CapitalizeText>
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
                <SidebarMenuButton v-else size="lg" as-child>
                    <Link :href="route('home')">
                        <AppLogo />
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>
</template>
