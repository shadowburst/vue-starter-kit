<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { ComboboxViewportProps } from 'reka-ui';
import { ComboboxViewport, useForwardProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<ComboboxViewportProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <ComboboxViewport
        v-bind="forwarded"
        data-slot="combobox-viewport"
        :class="cn('max-h-[300px] scroll-py-1 overflow-x-hidden overflow-y-auto', props.class)"
    >
        <slot />
    </ComboboxViewport>
</template>
