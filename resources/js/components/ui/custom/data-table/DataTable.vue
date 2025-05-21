<script lang="ts">
export type DataTableContext<TData> = {
    tab: Ref<DataTableTab>;
    rows: Ref<TData[]>;
    rowActions: Ref<DataTableRowAction<TData>[]>;
    rowsActions: Ref<DataTableRowsAction<TData>[]>;
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

export function injectDataTableRootContext<TData>(fallback?: DataTableContext<TData>): DataTableContext<TData> {
    const context = inject('DataTableRootContext', fallback);

    if (!context) {
        throw new Error(`Injection \`DataTableRootContext\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRootContext<TData>(contextValue: DataTableContext<TData>) {
    return provide('DataTableRootContext', contextValue);
}
</script>

<script setup lang="ts" generic="TData">
import { Tabs } from '@/components/ui/tabs';
import { PaginatedCollection } from '@/types';
import { computed, HTMLAttributes, inject, provide, Ref } from 'vue';
import { DataTableRowAction, DataTableRowsAction, DataTableTab } from './interface';

type Props = {
    data: TData[] | PaginatedCollection<TData>;
    rowActions?: DataTableRowAction<TData>[];
    rowsActions?: DataTableRowsAction<TData>[];
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    rowActions: () => [],
    rowsActions: () => [],
});

const tab = defineModel<DataTableTab>('tab', {
    default: 'table',
});

const rowActions = computed(() => props.rowActions);
const rowsActions = computed(() => props.rowsActions);
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
const selectedRows = defineModel<TData[]>('selectedRows', {
    default: () => [],
});
const selectedIndexes = computed<number[]>({
    get: () => selectedRows.value.map((row) => rows.value.indexOf(row)),
    set: (value) => (selectedRows.value = value.map((index) => rows.value[index])),
});
const isAllRowsSelected = computed(() => selectedIndexes.value.length === rows.value.length);
const isSomeRowsSelected = computed(
    () => selectedIndexes.value.length > 0 && selectedIndexes.value.length < rows.value.length,
);
const isAnyRowsSelected = computed(() => isAllRowsSelected.value || isSomeRowsSelected.value);

const pageSize = defineModel<number>('page-size', {
    default: 25,
});

const rootContext: DataTableContext<TData> = {
    tab,
    rows,
    rowActions,
    rowsActions,
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
    <Tabs class="grid gap-2" v-model="tab">
        <slot :rows />
    </Tabs>
</template>
