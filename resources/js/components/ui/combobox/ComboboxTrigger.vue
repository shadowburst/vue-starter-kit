<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { ComboboxTriggerProps } from 'reka-ui';
import { ComboboxTrigger, useForwardProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<ComboboxTriggerProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <ComboboxTrigger v-bind="forwarded" data-slot="combobox-trigger" :class="cn('', props.class)" tabindex="0">
        <slot />
    </ComboboxTrigger>
</template>
