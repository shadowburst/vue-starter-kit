<script setup lang="ts">
import { cn } from '@/lib/utils';
import { AvatarRoot } from 'reka-ui';
import { AvatarProps, avatarVariant } from '.';

const props = withDefaults(defineProps<AvatarProps>(), {
    size: 'sm',
    shape: 'circle',
});
</script>

<template>
    <AvatarRoot data-slot="avatar" :class="cn(avatarVariant({ size, shape }), props.class)">
        <slot />
    </AvatarRoot>
</template>
