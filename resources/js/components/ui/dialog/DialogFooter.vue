<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{ class?: HTMLAttributes['class'] }>();
</script>

<template>
    <div :class="cn('flex gap-4 max-sm:flex-col-reverse sm:justify-end', props.class)">
        <slot />
    </div>
</template>
