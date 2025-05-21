<script setup lang="ts">
import { cn } from '@/lib/utils';
import { LoaderCircleIcon } from 'lucide-vue-next';
import { HTMLAttributes } from 'vue';
import { loadingVariants, LoadingVariants } from '.';

type Props = {
    size?: LoadingVariants['size'];
    variant?: LoadingVariants['variant'];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <LoaderCircleIcon :class="cn(loadingVariants({ variant, size }), 'animate-spin', props.class)" />
</template>
