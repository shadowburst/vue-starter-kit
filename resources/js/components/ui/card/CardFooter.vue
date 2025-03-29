<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div :class="cn('flex justify-end gap-4 p-6 pt-0 max-sm:flex-col-reverse sm:items-center', props.class)">
        <slot />
    </div>
</template>
