import {
    DataTableHeadActions,
    DataTableHeadCheckbox,
    DataTableRowActions,
    DataTableRowCheckbox,
} from '@/components/ui/custom/data-table-v2';
import { useDataTable, UseDataTableOptions } from '@/composables/data-table';
import { UserResource } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { h } from 'vue';

export function useUserTable({
    data = [],
    actions = [],
    initialState = {},
    ...options
}: Partial<UseDataTableOptions<UserResource>>) {
    const table = useDataTable({
        data,
        actions,
        columns: [
            {
                id: 'select',
                header: () => h(DataTableHeadCheckbox),
                cell: () => h(DataTableRowCheckbox),
            },
            {
                id: 'full_name',
                accessorFn: (row) => row.full_name,
                header: () => trans('models.user.fields.full_name'),
            },
            {
                id: 'email',
                accessorFn: (row) => row.email,
                header: () => trans('models.user.fields.email'),
            },
            {
                id: 'phone',
                accessorFn: (row) => row.phone,
                header: () => trans('models.user.fields.phone'),
            },
            {
                id: 'deleted_at',
                accessorFn: (row) => row.deleted_at,
                header: () => trans('models.user.fields.deleted_at'),
                enableHiding: true,
            },
            {
                id: 'actions',
                header: () => h(DataTableHeadActions),
                cell: () => h(DataTableRowActions),
                enablePinning: true,
            },
        ],
        initialState: {
            columnPinning: {
                right: ['actions'],
            },
            columnVisibility: {
                deleted_at: false,
            },
            ...initialState,
        },
        ...options,
    });

    return {
        ...table,
        columns: ['select', 'full_name', 'email', 'phone', 'deleted_at', 'actions'] as const,
    };
}
