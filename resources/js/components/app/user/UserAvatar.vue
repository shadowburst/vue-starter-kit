<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import type { AuthUserResource } from '@/types';
import { computed } from 'vue';

type Props = {
    user: AuthUserResource;
};
const { user } = defineProps<Props>();

const initials = computed(() => {
    const first = user.first_name?.charAt(0)?.toUpperCase() ?? '';
    const last = user.last_name?.charAt(0)?.toUpperCase() ?? '';
    return `${first}${last}`;
});
</script>

<template>
    <Avatar class="size-8 overflow-hidden rounded-lg">
        <!-- <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" /> -->
        <AvatarFallback class="rounded-lg text-black dark:text-white">
            {{ initials }}
        </AvatarFallback>
    </Avatar>
</template>
