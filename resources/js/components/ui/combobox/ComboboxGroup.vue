<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { ComboboxGroupProps } from 'reka-ui';
import { ComboboxGroup, ComboboxLabel } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<
    ComboboxGroupProps & {
        class?: HTMLAttributes['class'];
        heading?: string;
    }
>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <ComboboxGroup
        v-bind="delegatedProps"
        data-slot="combobox-group"
        :class="cn('text-foreground overflow-hidden p-1', props.class)"
    >
        <ComboboxLabel class="text-muted-foreground px-2 py-1.5 text-xs font-medium" v-if="heading">
            {{ heading }}
        </ComboboxLabel>
        <slot />
    </ComboboxGroup>
</template>
