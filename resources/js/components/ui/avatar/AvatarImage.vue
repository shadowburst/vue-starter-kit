<script setup lang="ts">
import { AvatarImage, type AvatarImageProps } from 'radix-vue';

const props = defineProps<AvatarImageProps>();
</script>

<template>
    <AvatarImage class="h-full w-full object-cover" v-bind="props" />
</template>
