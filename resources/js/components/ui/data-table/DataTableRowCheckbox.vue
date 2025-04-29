<script setup lang="ts" generic="TData extends object">
import { Checkbox } from '@/components/ui/checkbox';
import { computed } from 'vue';
import { useDataTableRowContext } from './DataTableRow.vue';

const { isSelected, toggleSelected } = useDataTableRowContext<TData>();

const checked = computed<boolean>({
    get: () => isSelected.value,
    set: (value) => toggleSelected(value),
});
</script>

<template>
    <Checkbox v-model="checked" aria-label="Select row" />
</template>
