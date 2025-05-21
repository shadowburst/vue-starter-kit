<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { ComboboxItemIndicatorProps } from 'reka-ui';
import { ComboboxItemIndicator, useForwardProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<ComboboxItemIndicatorProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <ComboboxItemIndicator v-bind="forwarded" data-slot="combobox-item-indicator" :class="cn('ml-auto', props.class)">
        <slot />
    </ComboboxItemIndicator>
</template>
