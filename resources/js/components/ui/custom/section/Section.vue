<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div data-slot="section" :class="cn('bg-background text-foreground flex flex-col gap-6 py-4 sm:py-8', props.class)">
        <slot />
    </div>
</template>
