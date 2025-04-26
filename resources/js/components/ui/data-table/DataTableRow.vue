<script lang="ts">
export type DataTableRowContext<TData extends object> = {
    index: Ref<number>;
    item: Ref<TData>;
    isSelected: Ref<boolean>;
    toggleSelected: (value: boolean) => void;
};

export function useDataTableRowContext<TData extends object>(
    fallback?: DataTableRowContext<TData>,
): DataTableRowContext<TData> {
    const context = inject('dataTableRowContext', fallback);

    if (!context) {
        throw new Error(`Injection \`dataTableRowContext\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRowContext<TData extends object>(contextValue: DataTableRowContext<TData>) {
    return provide('dataTableRowContext', contextValue);
}
</script>

<script setup lang="ts" generic="TData extends object">
import { TableRow } from '@/components/ui/table';
import { computed, inject, provide, Ref } from 'vue';
import { useDataTableRootContext } from './DataTable.vue';

type Props = {
    index: number;
};
const props = defineProps<Props>();

const index = computed(() => props.index);
const rootContext = useDataTableRootContext<TData>();
const item = computed((): TData => rootContext.rows.value[index.value]);
const isSelected = computed(() => rootContext.getIsSelected(index.value));

const rowContext: DataTableRowContext<TData> = {
    index,
    item,
    isSelected,
    toggleSelected: (value) => rootContext.toggleSelected(index.value, value),
};
provideDataTableRowContext(rowContext);
</script>

<template>
    <TableRow :data-state="isSelected ? 'selected' : undefined">
        <slot />
    </TableRow>
</template>
