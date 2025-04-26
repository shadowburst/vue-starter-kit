<script setup lang="ts" generic="TData extends object">
import { Checkbox } from '@/components/ui/checkbox';
import { TableCell } from '@/components/ui/table';
import { computed } from 'vue';
import { useDataTableRowContext } from './DataTableRow.vue';

const rowContext = useDataTableRowContext<TData>();

const checked = computed<boolean>({
    get: () => rowContext.isSelected.value,
    set: (value) => rowContext.toggleSelected(value),
});
</script>

<template>
    <TableCell class="w-1">
        <Checkbox v-model="checked" aria-label="Select row" />
    </TableCell>
</template>
