<script setup lang="ts">
import UserAvatar from '@/components/app/user/UserAvatar.vue';
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { useAuth } from '@/composables';
import { Link } from '@inertiajs/vue3';
import { LogOutIcon, SettingsIcon } from 'lucide-vue-next';

const auth = useAuth();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserAvatar :user="auth.user" />
            <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-medium">{{ auth.user.full_name }}</span>
                <span class="truncate font-medium">{{ auth.user.email }}</span>
            </div>
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem as-child>
            <Link class="block w-full" :href="route('home')" as="button">
                <SettingsIcon class="mr-2 size-4" />
                Settings
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem as-child>
        <Link class="block w-full" method="post" :href="route('logout')" as="button">
            <LogOutIcon class="mr-2 size-4" />
            Log out
        </Link>
    </DropdownMenuItem>
</template>
