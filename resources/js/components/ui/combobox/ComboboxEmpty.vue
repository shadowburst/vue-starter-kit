<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { ComboboxEmptyProps } from 'reka-ui';
import { ComboboxEmpty } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<ComboboxEmptyProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <ComboboxEmpty
        v-bind="delegatedProps"
        data-slot="combobox-empty"
        :class="cn('py-6 text-center text-sm', props.class)"
    >
        <slot />
    </ComboboxEmpty>
</template>
