<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage, AvatarProps } from '@/components/ui/avatar';
import type { UserAuthResource } from '@/types';

type Props = AvatarProps & {
    user: Pick<UserAuthResource, 'initials' | 'full_name' | 'avatar'>;
};
const { user, ...props } = defineProps<Props>();
</script>

<template>
    <Avatar v-bind="props" :key="user.avatar?.id">
        <AvatarImage v-if="user.avatar" :src="user.avatar.url" :alt="user.full_name" />
        <AvatarFallback class="text-foreground rounded-lg">
            {{ user.initials }}
        </AvatarFallback>
    </Avatar>
</template>
