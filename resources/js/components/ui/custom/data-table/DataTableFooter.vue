<script setup lang="ts">
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <div :class="cn('flex items-center justify-between gap-2', props.class)">
        <slot />
    </div>
</template>
