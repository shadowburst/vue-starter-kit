<script setup lang="ts">
import TeamLogo from '@/components/team/TeamLogo.vue';
import TeamLogoIcon from '@/components/team/TeamLogoIcon.vue';
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
import { useAuth, usePageProp } from '@/composables';
import { TeamListResource } from '@/types';
import { Link } from '@inertiajs/vue3';
import { CheckIcon, ChevronsUpDownIcon, PlusIcon } from 'lucide-vue-next';

const { isMobile, state } = useSidebar();

const { team: currentTeam, abilities } = useAuth();
const teams = usePageProp<TeamListResource[]>('auth.user.teams', []);
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
                            <TeamLogo :team="currentTeam" />
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
                        <DropdownMenuGroup>
                            <DropdownMenuItem v-for="team in teams" :key="team.name" as-child>
                                <Link class="block w-full" method="patch" :href="route('teams.select', { team })">
                                    <TeamLogoIcon class="size-6" :media="team.logo" />
                                    <CapitalizeText>
                                        {{ team.name }}
                                    </CapitalizeText>
                                    <CheckIcon class="ml-auto" v-if="team.id === currentTeam.id" />
                                </Link>
                            </DropdownMenuItem>
                            <template v-if="abilities.teams.create">
                                <DropdownMenuSeparator />
                                <DropdownMenuItem as-child>
                                    <Link class="block w-full" :href="route('teams.create')">
                                        <PlusIcon />
                                        <CapitalizeText>
                                            {{ $t('pages.teams.create.title') }}
                                        </CapitalizeText>
                                    </Link>
                                </DropdownMenuItem>
                            </template>
                        </DropdownMenuGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
                <SidebarMenuButton v-else size="lg" as-child>
                    <Link :href="route('index')">
                        <TeamLogo :team="currentTeam" />
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>
</template>
