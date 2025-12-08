import { ActionItem } from '@/components/ui/custom/action-menu';
import { DataTableState } from '@/components/ui/custom/data-table-v2';
import { valueUpdater } from '@/components/ui/table/utils';
import { PaginatedCollection } from '@/types';
import {
    ColumnPinningState,
    getCoreRowModel,
    PaginationState,
    RowSelectionState,
    TableOptionsWithReactiveData,
    useVueTable,
} from '@tanstack/vue-table';
import { computed, MaybeRefOrGetter, ref, toValue, watch } from 'vue';

export type UseDataTableOptions<TData> = {
    data: MaybeRefOrGetter<PaginatedCollection<TData> | TData[]>;
    selectedActions?: (items: TData[]) => ActionItem[];
    rowActions?: (item: TData) => ActionItem[];
} & Pick<
    TableOptionsWithReactiveData<TData>,
    'columns' | 'initialState' | 'manualPagination' | 'rowCount' | 'onPaginationChange'
>;

export type UseDataTableReturn<TData> = {
    table: DataTableState<TData>;
    selectedActions?: (items: TData[]) => ActionItem[];
    rowActions?: (item: TData) => ActionItem[];
};

export function useDataTable<TData>({
    data,
    columns,
    selectedActions,
    rowActions,
    initialState = {},
    onPaginationChange,
    ...options
}: UseDataTableOptions<TData>): UseDataTableReturn<TData> {
    const paginatedData = computed(() => {
        const value = toValue(data);
        if (Array.isArray(value)) {
            return;
        }
        return value;
    });

    const rowSelection = ref<RowSelectionState>(initialState.rowSelection ?? {});
    const columnPinning = ref<ColumnPinningState>(initialState.columnPinning ?? {});
    const columnVisibility = ref<Record<string, boolean>>(initialState.columnVisibility ?? {});
    const pagination = ref<PaginationState>({
        pageIndex: paginatedData.value?.meta.current_page ? paginatedData.value.meta.current_page - 1 : 0,
        pageSize: paginatedData.value?.meta.per_page ?? 15,
        ...initialState.pagination,
    });

    const table = useVueTable<TData>({
        get data() {
            const value = toValue(data);
            return Array.isArray(value) ? value : value.data;
        },
        get columns() {
            return toValue(columns);
        },
        getCoreRowModel: getCoreRowModel(),
        onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
        onColumnPinningChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnPinning),
        onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
        onPaginationChange: (updaterOrValue) => {
            valueUpdater(updaterOrValue, pagination);
            table.resetRowSelection(true);
            onPaginationChange?.(updaterOrValue);
        },
        get manualPagination() {
            return paginatedData.value !== undefined || options.manualPagination;
        },
        get rowCount() {
            return paginatedData.value?.meta.total ?? options.rowCount;
        },
        state: {
            get rowSelection() {
                return rowSelection.value;
            },
            get columnPinning() {
                return columnPinning.value;
            },
            get columnVisibility() {
                return columnVisibility.value;
            },
            get pagination() {
                return pagination.value;
            },
        },
        ...options,
    });

    watch(paginatedData, () => {
        if (!paginatedData.value) {
            return;
        }
        if (
            paginatedData.value.meta.current_page === table.getState().pagination.pageIndex + 1 &&
            paginatedData.value.meta.per_page === table.getState().pagination.pageSize
        ) {
            return;
        }
        table.setPageSize(paginatedData.value.meta.per_page);
        table.setPageIndex(paginatedData.value.meta.current_page - 1);
    });

    return { table, selectedActions, rowActions };
}
