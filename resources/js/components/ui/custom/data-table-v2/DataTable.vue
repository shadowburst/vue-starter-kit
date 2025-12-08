<script lang="ts">
type DataTableRootContext<TData> = {
    table: Ref<UseDataTableReturn<TData>['table']>;
    getActions: (items: TData[]) => ActionItem[];
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
import { ActionItem } from '@/components/ui/custom/action-menu';
import { Table, TableBody, TableHeader } from '@/components/ui/table';
import { UseDataTableReturn } from '@/composables/data-table';
import { FlexRender } from '@tanstack/vue-table';
import { computed, inject, provide, Ref } from 'vue';
import DataTableCell from './DataTableCell.vue';
import DataTableEmpty from './DataTableEmpty.vue';
import DataTableHead from './DataTableHead.vue';
import DataTablePagination from './DataTablePagination.vue';
import DataTableRow from './DataTableRow.vue';
import { DataTableState } from './interface';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    table: DataTableState<TData>;
    columns: readonly TColumn[];
    getActions?: (items: TData[]) => ActionItem[];
};
const props = withDefaults(defineProps<Props>(), {
    getActions: () => [],
});

provideDataTableRootContext<TData>({
    table: computed(() => props.table),
    getActions: props.getActions,
});
</script>

<template>
    <div class="grid gap-y-4">
        <Table v-bind="$attrs" class="relative overflow-x-auto">
            <TableHeader>
                <DataTableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                    <DataTableHead v-for="header in headerGroup.headers" :key="header.id" :header>
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
                        <DataTableCell v-for="cell in row.getVisibleCells()" :key="cell.id" :cell>
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
