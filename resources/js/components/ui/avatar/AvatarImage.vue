<script setup lang="ts">
import type { AvatarImageProps } from 'reka-ui';
import { AvatarImage } from 'reka-ui';

const props = defineProps<AvatarImageProps>();
</script>

<template>
    <AvatarImage class="h-full w-full object-cover" v-bind="props">
        <slot />
    </AvatarImage>
</template>
