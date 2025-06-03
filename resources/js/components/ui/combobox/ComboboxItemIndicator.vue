<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { ComboboxItemIndicatorProps, injectComboboxItemContext, useForwardProps } from 'reka-ui';

const props = defineProps<ComboboxItemIndicatorProps>();
const forwarded = useForwardProps(props);

const { isSelected } = injectComboboxItemContext();
</script>

<template>
    <Checkbox v-bind="forwarded" :model-value="isSelected" />
</template>
