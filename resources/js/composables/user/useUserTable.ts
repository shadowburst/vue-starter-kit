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
                header: (props) => h(DataTableHeadCheckbox, props),
                cell: (props) => h(DataTableRowCheckbox, props),
            },
            {
                accessorKey: 'full_name',
                header: () => trans('models.user.fields.full_name'),
            },
            {
                accessorKey: 'email',
                header: () => trans('models.user.fields.email'),
            },
            {
                accessorKey: 'phone',
                header: () => trans('models.user.fields.phone'),
            },
            {
                accessorKey: 'deleted_at',
                header: () => trans('models.user.fields.deleted_at'),
                enableHiding: true,
            },
            {
                id: 'actions',
                header: (props) => h(DataTableHeadActions, props),
                cell: (props) => h(DataTableRowActions, props),
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
