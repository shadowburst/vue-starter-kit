<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import {
    ComboboxItemIndicatorProps,
    injectComboboxItemContext,
    injectComboboxRootContext,
    useForwardProps,
} from 'reka-ui';

const props = defineProps<ComboboxItemIndicatorProps>();
const forwarded = useForwardProps(props);

const { multiple, modelValue } = injectComboboxRootContext();
const { isSelected } = injectComboboxItemContext();
</script>

<template>
    <Checkbox
        v-if="multiple || modelValue"
        v-bind="forwarded"
        :model-value="isSelected"
        :class="{ invisible: !multiple && !isSelected }"
    />
</template>
