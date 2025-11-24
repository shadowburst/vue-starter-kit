<script lang="ts">
export type DataTableRowContext<TData> = {
    row: Ref<Row<TData> | undefined>;
};

export function injectDataTableRowContext<TData>(fallback?: DataTableRowContext<TData>): DataTableRowContext<TData> {
    const context = inject('DataTableRowContext', fallback);

    if (!context) {
        throw new Error(`Injection \`DataTableRowContext\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRowContext<TData>(contextValue: DataTableRowContext<TData>) {
    return provide('DataTableRowContext', contextValue);
}
</script>

<script setup lang="ts" generic="TData">
import { TableRow } from '@/components/ui/table';
import { Row } from '@tanstack/vue-table';
import { inject, provide, Ref, toRefs } from 'vue';

type Props = {
    row?: Row<TData>;
};
const props = defineProps<Props>();

const { row } = toRefs(props);

provideDataTableRowContext({
    row,
});
</script>

<template>
    <TableRow :data-state="row?.getIsSelected() ? 'selected' : undefined">
        <slot />
    </TableRow>
</template>
