<script setup lang="ts">
import type { AvatarImageProps } from 'reka-ui';
import { AvatarImage } from 'reka-ui';

const props = defineProps<AvatarImageProps>();
</script>

<template>
    <AvatarImage class="aspect-square size-full object-cover" v-bind="props" data-slot="avatar-image">
        <slot />
    </AvatarImage>
</template>
