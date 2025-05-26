<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div data-slot="section-content" :class="cn('px-4 sm:px-8', props.class)">
        <slot />
    </div>
</template>
