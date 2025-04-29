<script lang="ts">
export type DataTableRowContext<TData extends object> = {
    item: Ref<TData>;
    isSelected: Ref<boolean>;
    toggleSelected: (value: boolean) => void;
};

export function useDataTableRowContext<TData extends object>(
    fallback?: DataTableRowContext<TData>
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
    item?: TData;
};
const { item } = defineProps<Props>();

const rootContext = useDataTableRootContext<TData>();

const rowContext: DataTableRowContext<TData> | undefined = item
    ? {
          item: computed(() => item),
          isSelected: computed(() => rootContext.getIsSelected(item)),
          toggleSelected: (value) => rootContext.toggleSelected(item, value),
      }
    : undefined;
if (rowContext) {
    provideDataTableRowContext(rowContext);
}
</script>

<template>
    <TableRow :data-state="rowContext?.isSelected.value ? 'selected' : undefined">
        <slot />
    </TableRow>
</template>
