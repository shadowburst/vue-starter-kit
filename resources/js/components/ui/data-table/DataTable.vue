<script lang="ts">
export type DataTableContext<TData extends object> = {
    rows: Ref<TData[]>;
    rowActions: Ref<DataTableAction<TData>[]>;
    massActions: Ref<DataTableMassAction<TData>[]>;
    pagination: Ref<Pick<PaginatedCollection<TData>, 'links' | 'meta'> | undefined>;
    selectedRows: Ref<TData[]>;
    isAllRowsSelected: Ref<boolean>;
    isSomeRowsSelected: Ref<boolean>;
    getIsSelected: (index: number) => boolean;
    toggleAllRowsSelected: (value: boolean) => void;
    toggleSelected: (index: number, value: boolean) => void;
};

export function useDataTableRootContext<TData extends object>(
    fallback?: DataTableContext<TData>,
): DataTableContext<TData> {
    const context = inject('dataTableRootContext', fallback);

    if (!context) {
        throw new Error(`Injection \`dataTableRootContext\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRootContext<TData extends object>(contextValue: DataTableContext<TData>) {
    return provide('dataTableRootContext', contextValue);
}
</script>

<script setup lang="ts" generic="TData extends object">
import { Capitalize } from '@/components/typography';
import { Card, CardContent } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHeader, TableRow } from '@/components/ui/table';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { PaginatedCollection } from '@/types';
import { Grid3x3Icon, ListIcon } from 'lucide-vue-next';
import { Slot } from 'reka-ui';
import { computed, inject, provide, Ref, ref, useSlots } from 'vue';
import DataTableMassActionsDropdown from './DataTableMassActionsDropdown.vue';
import DataTablePagination from './DataTablePagination.vue';
import { DataTableAction, DataTableMassAction } from './interface';

const props = defineProps<{
    data: TData[] | PaginatedCollection<TData>;
    rowActions?: DataTableAction<TData>[];
    massActions?: DataTableMassAction<TData>[];
}>();

const rowActions = computed(() => props.rowActions ?? []);
const massActions = computed(() => props.massActions ?? []);
const rows = computed((): TData[] => (Array.isArray(props.data) ? props.data : props.data.data));
const pagination = computed(() => {
    if (Array.isArray(props.data)) {
        return;
    }

    return {
        links: props.data.links,
        meta: props.data.meta,
    };
});
const selectedRows = computed(() => rows.value.filter((_, index) => selectedIndexes.value.includes(index)));
const isAllRowsSelected = computed(() => selectedIndexes.value.length === rows.value.length);
const isSomeRowsSelected = computed(
    () => selectedIndexes.value.length > 0 && selectedIndexes.value.length < rows.value.length,
);

const slots = useSlots();

const view = ref<'table' | 'card'>(slots.row ? 'table' : 'card');

const selectedIndexes = ref<number[]>([]);
const rootContext: DataTableContext<TData> = {
    rows,
    rowActions,
    massActions,
    pagination,
    selectedRows,
    isAllRowsSelected,
    isSomeRowsSelected,
    getIsSelected: (index: number) => selectedIndexes.value.includes(index),
    toggleAllRowsSelected: (value: boolean) => {
        selectedIndexes.value = value ? rows.value.map((_, index) => index) : [];
    },
    toggleSelected: (index: number, value: boolean) => {
        const filteredIndexes = selectedIndexes.value.filter((_, i) => i !== index);
        selectedIndexes.value = value ? [...filteredIndexes, index] : filteredIndexes;
    },
};
provideDataTableRootContext(rootContext);
</script>

<template>
    <Tabs class="max-w-full overflow-x-auto" v-model="view">
        <div class="flex items-center gap-2">
            <DataTableMassActionsDropdown />
            <TabsList class="ml-auto" v-if="$slots.row && $slots.card">
                <TabsTrigger value="table">
                    <ListIcon />
                </TabsTrigger>
                <TabsTrigger value="grid">
                    <Grid3x3Icon />
                </TabsTrigger>
            </TabsList>
        </div>
        <TabsContent value="table">
            <div class="rounded-md border">
                <Table>
                    <TableHeader v-if="$slots.header">
                        <slot name="header" />
                    </TableHeader>
                    <TableBody>
                        <template v-if="rows.length">
                            <Slot v-for="(item, index) in rows" :key="index" :item :index>
                                <slot name="row" />
                            </Slot>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell class="h-24 text-center" colspan="100">
                                    <Capitalize>
                                        {{ $t('components.ui.data_table.empty') }}
                                    </Capitalize>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
        </TabsContent>
        <TabsContent value="card">
            <Card v-for="(item, index) in rows" :key="index">
                <CardContent> </CardContent>
            </Card>
        </TabsContent>
        <DataTablePagination />
    </Tabs>
</template>
