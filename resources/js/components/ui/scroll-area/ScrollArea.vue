<script setup lang="ts">
import { cn } from '@/lib/utils';
import { ScrollAreaCorner, ScrollAreaRoot, type ScrollAreaRootProps, ScrollAreaViewport } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';
import ScrollBar from './ScrollBar.vue';

const props = defineProps<ScrollAreaRootProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <ScrollAreaRoot v-bind="delegatedProps" data-slot="scroll-area" :class="cn('relative', props.class)">
        <ScrollAreaViewport
            class="focus-visible:ring-ring/50 size-full rounded-[inherit] transition-[color,box-shadow] outline-none focus-visible:ring-[3px] focus-visible:outline-1"
            data-slot="scroll-area-viewport"
        >
            <slot />
        </ScrollAreaViewport>
        <ScrollBar />
        <ScrollAreaCorner />
    </ScrollAreaRoot>
</template>
