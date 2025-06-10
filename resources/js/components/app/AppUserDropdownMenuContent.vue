<script setup lang="ts">
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { clearSessionFilters, useAuth } from '@/composables';
import { BuildingIcon, LogOutIcon, SettingsIcon, UsersIcon } from 'lucide-vue-next';

const { user, abilities } = useAuth();
</script>

<template>
    <DropdownMenuGroup>
        <DropdownMenuLabel class="p-0 font-normal">
            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                <UserAvatar :user />
                <div class="grid flex-1 text-left text-sm leading-tight">
                    <span class="truncate font-medium">{{ user.full_name }}</span>
                    <span class="truncate font-medium">{{ user.email }}</span>
                </div>
            </div>
        </DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuItem v-if="abilities.view_any_teams" as-child>
            <InertiaLink :href="route('teams.index')" :onBefore="() => clearSessionFilters(route('teams.index'))">
                <BuildingIcon />
                {{ $t('pages.teams.index.title') }}
            </InertiaLink>
        </DropdownMenuItem>
        <DropdownMenuItem v-if="abilities.view_any_users" as-child>
            <InertiaLink
                :href="route('users.members.index')"
                :onBefore="() => clearSessionFilters(route('users.members.index'))"
            >
                <UsersIcon />
                {{ $t('pages.users.members.index.title') }}
            </InertiaLink>
        </DropdownMenuItem>
        <DropdownMenuSeparator v-if="abilities.view_any_teams || abilities.view_any_users" />
        <DropdownMenuItem as-child>
            <InertiaLink :href="route('settings.index')">
                <SettingsIcon />
                {{ $t('pages.settings.title') }}
            </InertiaLink>
        </DropdownMenuItem>
        <DropdownMenuSeparator />
        <DropdownMenuItem as-child>
            <InertiaLink class="w-full" method="post" :href="route('logout')">
                <LogOutIcon />
                <CapitalizeText>
                    {{ $t('logout') }}
                </CapitalizeText>
            </InertiaLink>
        </DropdownMenuItem>
    </DropdownMenuGroup>
</template>
