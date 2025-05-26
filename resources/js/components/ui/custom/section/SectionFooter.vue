<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div data-slot="section-footer" :class="cn('flex items-center gap-2 px-4 sm:px-8 [.border-t]:pt-8', props.class)">
        <slot />
    </div>
</template>
