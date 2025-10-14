<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { cn } from '@/lib/utils';
import type { PartialPick, UserResource } from '@/types';
import { cva, VariantProps } from 'class-variance-authority';
import { computed, HTMLAttributes } from 'vue';

const avatarVariant = cva('', {
    variants: {
        size: {
            sm: 'size-10 text-xs',
            base: 'size-16 text-2xl',
            lg: 'size-32 text-5xl',
        },
    },
});
type AvatarVariants = VariantProps<typeof avatarVariant>;

type Props = {
    user: PartialPick<UserResource, 'first_name' | 'last_name'>;
    size?: AvatarVariants['size'];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const initials = computed(() =>
    [props.user.first_name[0]?.toUpperCase(), props.user.last_name[0]?.toUpperCase()].filter(Boolean).join(''),
);
</script>

<template>
    <Avatar :key="user.avatar?.id" :class="cn(avatarVariant({ size }), props.class)">
        <AvatarImage v-if="user.avatar" :src="user.avatar.url" :alt="user.full_name" />
        <AvatarFallback class="text-foreground rounded-lg">
            {{ initials }}
        </AvatarFallback>
    </Avatar>
</template>
