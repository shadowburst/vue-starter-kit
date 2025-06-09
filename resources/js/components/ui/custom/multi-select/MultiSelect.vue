<script lang="ts">
export type MultiSelectRootProps<T = AcceptableValue> = ComboboxRootProps<T> & {
    displayValue: (value: T) => string;
};
export type MultiSelectRootEmits<T = AcceptableValue> = ComboboxRootEmits<T>;

export type MultiSelectRootContext<T = AcceptableValue> = {
    displayValue: MultiSelectRootProps<T>['displayValue'];
};

export const [injectMultiSelectRootContext, provideMultiSelectRootContext] =
    createContext<MultiSelectRootContext>('MultiSelectRoot');
</script>

<script setup lang="ts">
import { Combobox } from '@/components/ui/combobox';
import { reactiveOmit } from '@vueuse/core';
import { AcceptableValue, ComboboxRootEmits, ComboboxRootProps, createContext, useForwardPropsEmits } from 'reka-ui';

const props = defineProps<MultiSelectRootProps>();
const emits = defineEmits<MultiSelectRootEmits>();
const delegatedProps = reactiveOmit(props, 'displayValue');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

provideMultiSelectRootContext({
    displayValue: props.displayValue,
});
</script>

<template>
    <Combobox v-bind="forwarded">
        <slot />
    </Combobox>
</template>
