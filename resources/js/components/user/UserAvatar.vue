<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage, AvatarProps } from '@/components/ui/avatar';
import type { PartialPick, UserResource } from '@/types';
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';
import { computed } from 'vue';

type Props = AvatarProps & {
    user: PartialPick<UserResource, 'first_name' | 'last_name'>;
};
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'user');
const forwarded = useForwardProps(delegatedProps);

const initials = computed(() =>
    [props.user.first_name[0]?.toUpperCase(), props.user.last_name[0]?.toUpperCase()].filter(Boolean).join(''),
);
</script>

<template>
    <Avatar v-bind="forwarded" :key="user.avatar?.id">
        <AvatarImage v-if="user.avatar" :src="user.avatar.url" :alt="user.full_name" />
        <AvatarFallback class="text-foreground rounded-lg">
            {{ initials }}
        </AvatarFallback>
    </Avatar>
</template>
