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
    <div :class="cn(loadingIconVariants({ variant, size }), 'grid place-items-center')">
        <CircleIcon :class="cn('col-start-1 row-start-1 fill-current', props.class)" />
        <CircleIcon :class="cn('col-start-1 row-start-1 scale-80 animate-ping fill-current', props.class)" />
    </div>
</template>
