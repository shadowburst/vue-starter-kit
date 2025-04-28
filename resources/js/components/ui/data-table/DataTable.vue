<script lang="ts">
export type DataTableContext<TData extends object> = {
    rows: Ref<TData[]>;
    rowActions: Ref<DataTableAction<TData>[]>;
    massActions: Ref<DataTableMassAction<TData>[]>;
    pagination: Ref<Pick<PaginatedCollection<TData>, 'links' | 'meta'> | undefined>;
    selectedRows: Ref<TData[]>;
    isAllRowsSelected: Ref<boolean>;
    isSomeRowsSelected: Ref<boolean>;
    isAnyRowsSelected: Ref<boolean>;
    getIsSelected: (item: TData) => boolean;
    toggleAllRowsSelected: (value: boolean) => void;
    toggleSelected: (item: TData, value: boolean) => void;
    setPageSize: (value: number) => void;
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
import { Table, TableBody, TableCell, TableHeader, TableRow } from '@/components/ui/table';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { array } from '@/lib';
import { PaginatedCollection } from '@/types';
import { Arrayable } from '@vueuse/core';
import { Grid3x3Icon, ListIcon } from 'lucide-vue-next';
import { computed, inject, provide, Ref, ref } from 'vue';
import DataTableMassActionsDropdown from './DataTableMassActionsDropdown.vue';
import DataTablePagination from './DataTablePagination.vue';
import { DataTableAction, DataTableMassAction } from './interface';

type View = 'table' | 'card';
type Props = {
    data: TData[] | PaginatedCollection<TData>;
    rowActions?: DataTableAction<TData>[];
    massActions?: DataTableMassAction<TData>[];
    views?: Arrayable<View>;
};
const props = withDefaults(defineProps<Props>(), {
    rowActions: () => [],
    massActions: () => [],
    views: () => ['table', 'card'],
});

type Slots = {
    headers(props: {}): any;
    rows(props: { view: View; items: TData[] }): any;
};
defineSlots<Slots>();

const view = defineModel<View>('view', {
    default: 'table',
});
const views = computed(() => {
    const values = array.wrap(props.views);
    return [...new Set(values)];
});

const rowActions = computed(() => props.rowActions);
const massActions = computed(() => props.massActions);
const pagination = computed(() => {
    if (Array.isArray(props.data)) {
        return;
    }

    return {
        links: props.data.links,
        meta: props.data.meta,
    };
});

const rows = computed((): TData[] => (Array.isArray(props.data) ? props.data : props.data.data));
const selectedIndexes = ref<number[]>([]);
const selectedRows = computed(() => rows.value.filter((_, index) => selectedIndexes.value.includes(index)));
const isAllRowsSelected = computed(() => selectedIndexes.value.length === rows.value.length);
const isSomeRowsSelected = computed(
    () => selectedIndexes.value.length > 0 && selectedIndexes.value.length < rows.value.length,
);
const isAnyRowsSelected = computed(() => isAllRowsSelected.value || isSomeRowsSelected.value);

const pageSize = defineModel<number>('page-size', {
    default: 25,
});

const rootContext: DataTableContext<TData> = {
    rows,
    rowActions,
    massActions,
    pagination,
    selectedRows,
    isAllRowsSelected,
    isSomeRowsSelected,
    isAnyRowsSelected,
    getIsSelected: (item: TData) => selectedIndexes.value.includes(rows.value.indexOf(item)),
    toggleAllRowsSelected: (value: boolean) => {
        selectedIndexes.value = value ? rows.value.map((_, index) => index) : [];
    },
    toggleSelected: (item: TData, value: boolean) => {
        const index = rows.value.indexOf(item);
        const filteredIndexes = selectedIndexes.value.filter((i) => i !== index);
        selectedIndexes.value = value ? [...filteredIndexes, index] : filteredIndexes;
    },
    setPageSize: (value: number) => (pageSize.value = value),
};
provideDataTableRootContext(rootContext);
</script>

<template>
    <Tabs class="max-w-full overflow-x-auto" v-model="view">
        <div class="flex items-center gap-2">
            <DataTableMassActionsDropdown />
            <TabsList class="ml-auto" v-if="views.length > 1">
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
                    <TableHeader v-if="$slots.headers">
                        <slot name="headers" />
                    </TableHeader>
                    <TableBody>
                        <template v-if="rows.length">
                            <slot name="rows" view="table" :items="rows" />
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
            <template v-if="rows.length">
                <slot name="rows" view="card" :items="rows" />
            </template>
            <template v-else>
                <div class="grid place-items-center">
                    <Capitalize>
                        {{ $t('components.ui.data_table.empty') }}
                    </Capitalize>
                </div>
            </template>
        </TabsContent>
        <DataTablePagination />
    </Tabs>
</template>
