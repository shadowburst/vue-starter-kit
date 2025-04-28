<script setup lang="ts" generic="TData extends object">
import { Checkbox } from '@/components/ui/checkbox';
import { TableCell } from '@/components/ui/table';
import { computed } from 'vue';
import { useDataTableRowContext } from './useDataTableRowContext';

const { isSelected, toggleSelected } = useDataTableRowContext<TData>();

const checked = computed<boolean>({
    get: () => isSelected.value,
    set: (value) => toggleSelected(value),
});
</script>

<template>
    <TableCell class="w-1">
        <Checkbox v-model="checked" aria-label="Select row" />
    </TableCell>
</template>
