<script lang="ts">
export type DataTableContext<TData> = {
    loading: Ref<boolean>;
    tab: Ref<DataTableTab>;
    sortBy: Ref<string | undefined>;
    sortDirection: Ref<string | undefined>;
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
};

export function injectDataTableRootContext<TData>(fallback?: DataTableContext<TData>): DataTableContext<TData> {
    const context = inject('DataTableRoot', fallback);

    if (!context) {
        throw new Error(`Injection \`DataTableRoot\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRootContext<TData>(contextValue: DataTableContext<TData>) {
    return provide('DataTableRoot', contextValue);
}
</script>

<script setup lang="ts" generic="TData">
import { Tabs } from '@/components/ui/tabs';
import { PaginatedCollection } from '@/types';
import { computed, HTMLAttributes, inject, provide, Ref } from 'vue';
import { DataTableRowAction, DataTableRowsAction, DataTableTab } from './interface';

type Props = {
    data?: TData[] | PaginatedCollection<TData>;
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
    const { data } = props;
    if (!data) {
        return;
    }
    if (Array.isArray(data)) {
        return;
    }

    return {
        links: data.links,
        meta: data.meta,
    };
});

const rows = computed((): TData[] => {
    const { data } = props;
    if (!data) {
        return [];
    }
    if (Array.isArray(data)) {
        return data;
    }
    return data.data;
});
const selectedRows = defineModel<TData[]>('selectedRows', {
    default: () => [],
});
const selectedIndexes = computed<number[]>({
    get: () => selectedRows.value.map((row) => rows.value.indexOf(row)),
    set: (value) => (selectedRows.value = value.map((index) => rows.value[index])),
});
const isAllRowsSelected = computed(
    () => selectedIndexes.value.length > 0 && selectedIndexes.value.length === rows.value.length,
);
const isSomeRowsSelected = computed(
    () => selectedIndexes.value.length > 0 && selectedIndexes.value.length < rows.value.length,
);
const isAnyRowsSelected = computed(() => isAllRowsSelected.value || isSomeRowsSelected.value);

const sortBy = defineModel<string>('sortBy');
const sortDirection = defineModel<string>('sortDirection');

const loading = computed(() => !props.data);

const rootContext: DataTableContext<TData> = {
    loading,
    tab,
    sortBy,
    sortDirection,
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
};
provideDataTableRootContext(rootContext);
</script>

<template>
    <Tabs class="max-w-full" v-model="tab" orientation="vertical">
        <slot :rows />
    </Tabs>
</template>
