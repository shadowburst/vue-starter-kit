<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div
        data-slot="section-header"
        :class="
            cn(
                '@container/section-header grid auto-rows-min grid-rows-[auto_auto] items-start gap-2 px-4 has-data-[slot=section-action]:grid-cols-[1fr_auto] sm:px-8 [.border-b]:pb-8',
                props.class,
            )
        "
    >
        <slot />
    </div>
</template>
