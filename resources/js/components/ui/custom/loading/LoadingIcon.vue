<script setup lang="ts">
import { cn } from '@/lib/utils';
import { CircleIcon } from 'lucide-vue-next';
import { HTMLAttributes } from 'vue';
import { loadingIconVariants, LoadingIconVariants } from '.';

type Props = {
    variant?: LoadingIconVariants['variant'];
    size?: LoadingIconVariants['size'];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <CircleIcon :class="cn(loadingIconVariants({ variant, size }), props.class)" />
</template>
