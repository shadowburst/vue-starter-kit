import { DataTableAction } from '@/components/ui/custom/data-table-v2';
import { valueUpdater } from '@/components/ui/table/utils';
import { ColumnDef, getCoreRowModel, Table, TableOptionsWithReactiveData, useVueTable } from '@tanstack/vue-table';
import { MaybeRefOrGetter, ref, toValue } from 'vue';

export type UseDataTableOptions<TData> = {
    data: MaybeRefOrGetter<TData[]>;
    columns: ColumnDef<TData>[];
    actions?: DataTableAction<TData>[];
};
export type UseDataTableReturn<TData> = {
    table: Table<TData>;
    actions: DataTableAction<TData>[];
};
export function useDataTable<TData>({
    data,
    columns,
    actions = [],
}: UseDataTableOptions<TData>): UseDataTableReturn<TData> {
    const options: Partial<TableOptionsWithReactiveData<TData>> = {
        state: {},
    };

    const hasMultiActions = actions.some((action) => action.type === 'multi');
    if (hasMultiActions) {
        const rowSelection = ref({});
        options.onRowSelectionChange = (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection);
        options.state = {
            ...options.state,
            get rowSelection() {
                return rowSelection.value;
            },
        };
    }

    const table = useVueTable({
        get data() {
            return toValue(data);
        },
        get columns() {
            return toValue(columns);
        },
        getCoreRowModel: getCoreRowModel(),
        ...options,
    });

    return { table, actions };
}
