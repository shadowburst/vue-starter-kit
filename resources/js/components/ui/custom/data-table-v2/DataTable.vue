<script lang="ts">
type DataTableRootContext<TData> = {
    table: Ref<UseDataTableReturn<TData>['table']>;
    multiActions: Ref<DataTableMultiAction<TData>[]>;
    rowActions: Ref<DataTableRowAction<TData>[]>;
};

export function injectDataTableRootContext<TData>(fallback?: DataTableRootContext<TData>): DataTableRootContext<TData> {
    const context = inject('DataTableRoot', fallback);

    if (!context) {
        throw new Error(`Injection \`DataTableRoot\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRootContext<TData>(contextValue: DataTableRootContext<TData>) {
    return provide('DataTableRoot', contextValue);
}
</script>

<script setup lang="ts" generic="TData, TColumn extends string">
import { Table, TableBody, TableHeader } from '@/components/ui/table';
import { UseDataTableReturn } from '@/composables/data-table';
import { Column, FlexRender } from '@tanstack/vue-table';
import { computed, HTMLAttributes, inject, provide, Ref, toRefs } from 'vue';
import DataTableCell from './DataTableCell.vue';
import DataTableEmpty from './DataTableEmpty.vue';
import DataTableHead from './DataTableHead.vue';
import DataTablePagination from './DataTablePagination.vue';
import DataTableRow from './DataTableRow.vue';
import { DataTableAction, DataTableMultiAction, DataTableRowAction, DataTableState } from './interface';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    table: DataTableState<TData>;
    columns: readonly TColumn[];
    actions?: DataTableAction<TData>[];
};
const props = withDefaults(defineProps<Props>(), {
    actions: () => [],
});

const { table, actions } = toRefs(props);

const multiActions = computed(() => actions.value.filter((action) => action.type === 'multi'));
const rowActions = computed(() => actions.value.filter((action) => action.type !== 'multi'));
provideDataTableRootContext<TData>({
    table,
    multiActions,
    rowActions,
});

function columnStyle(column: Column<TData, unknown>): HTMLAttributes['style'] {
    const columnStyle: HTMLAttributes['style'] = {};

    const isPinned = column.getIsPinned();
    if (isPinned) {
        columnStyle.left = isPinned === 'left' ? `${column.getStart('left')}px` : undefined;
        columnStyle.right = isPinned === 'right' ? `${column.getAfter('right')}px` : undefined;
        columnStyle.position = 'sticky';
        columnStyle.width = column.getSize();
        columnStyle.zIndex = 1;

        if (isPinned === 'left' && column.getIsLastColumn('left')) {
            columnStyle.boxShadow = '-1px 0 0 0 var(--border) inset';
        }
        if (isPinned === 'right' && column.getIsFirstColumn('right')) {
            columnStyle.boxShadow = '1px 0 0 0 var(--border) inset';
        }
    }

    return columnStyle;
}
</script>

<template>
    <div class="grid gap-y-4">
        <Table v-bind="$attrs" class="relative overflow-x-auto">
            <TableHeader>
                <DataTableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                    <DataTableHead
                        v-for="header in headerGroup.headers"
                        :key="header.id"
                        :style="columnStyle(header.column)"
                    >
                        <FlexRender
                            v-if="!header.isPlaceholder"
                            :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </DataTableHead>
                </DataTableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                    <DataTableRow v-for="row in table.getRowModel().rows" :key="row.id" :row>
                        <DataTableCell
                            v-for="cell in row.getVisibleCells()"
                            :key="cell.id"
                            :style="columnStyle(cell.column)"
                        >
                            <slot :name="cell.column.id as TColumn" v-bind="cell.getContext()">
                                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </slot>
                        </DataTableCell>
                    </DataTableRow>
                </template>
                <template v-else>
                    <DataTableRow>
                        <DataTableCell :colspan="table.getAllFlatColumns().length">
                            <DataTableEmpty />
                        </DataTableCell>
                    </DataTableRow>
                </template>
            </TableBody>
        </Table>
        <DataTablePagination />
    </div>
</template>
