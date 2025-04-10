<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div
        data-slot="card-footer"
        :class="cn('flex justify-end gap-4 px-6 max-sm:flex-col-reverse sm:items-center [.border-t]:pt-6', props.class)"
    >
        <slot />
    </div>
</template>
