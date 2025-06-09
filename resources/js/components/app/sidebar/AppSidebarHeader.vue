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
import { useAuth } from '@/composables';
import { NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ChevronsUpDownIcon, CircleIcon } from 'lucide-vue-next';
import { computed } from 'vue';

const { isMobile, state } = useSidebar();

const { user } = useAuth();

const teams = computed((): NavItem[] =>
    user.teams.map((team) => ({
        title: team.name,
        href: route('teams.select', { team }),
        isActive: user.team_id === team.id,
        options: { method: 'patch' },
    })),
);
</script>

<template>
    <SidebarHeader>
        <SidebarMenu>
            <SidebarMenuItem>
                <DropdownMenu v-if="teams.length > 1">
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
                                {{ $t('models.team.name.many') }}
                            </CapitalizeText>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuGroup>
                            <DropdownMenuItem
                                v-for="{ title, href, isActive, options = {} } in teams"
                                :key="title"
                                as-child
                            >
                                <Link class="block w-full" v-bind="options" :href>
                                    <CircleIcon :class="{ 'text-primary fill-current': isActive }" />
                                    <CapitalizeText>
                                        {{ title }}
                                    </CapitalizeText>
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
                <SidebarMenuButton v-else size="lg" as-child>
                    <Link :href="route('index')">
                        <AppLogo />
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>
</template>
