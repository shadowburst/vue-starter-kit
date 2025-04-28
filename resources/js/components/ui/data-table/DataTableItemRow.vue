<script setup lang="ts" generic="TData extends object">
import { TableRow } from '@/components/ui/table';
import { computed } from 'vue';
import { useDataTableRootContext } from './DataTable.vue';
import { DataTableRowContext, provideDataTableRowContext } from './useDataTableRowContext';

type Props = {
    item: TData;
};
const { item } = defineProps<Props>();

const rootContext = useDataTableRootContext<TData>();
const isSelected = computed(() => rootContext.getIsSelected(item));

const rowContext: DataTableRowContext<TData> = {
    item: computed(() => item),
    isSelected,
    toggleSelected: (value) => rootContext.toggleSelected(item, value),
};
provideDataTableRowContext(rowContext);
</script>

<template>
    <TableRow :data-state="isSelected ? 'selected' : undefined">
        <slot />
    </TableRow>
</template>
