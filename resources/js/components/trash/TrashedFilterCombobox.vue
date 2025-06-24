<script setup lang="ts">
import { EnumCombobox, EnumComboboxEmits, EnumComboboxProps } from '@/components/ui/custom/combobox';
import { TrashedFilter } from '@/types';
import { useForwardPropsEmits } from 'reka-ui';

type T = TrashedFilter;
type Props = Partial<EnumComboboxProps<T>>;
const props = withDefaults(defineProps<Props>(), {
    data: 'trashedFilters',
});
const emits = defineEmits<EnumComboboxEmits<T>>();
const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <EnumCombobox v-bind="forwarded" />
</template>
