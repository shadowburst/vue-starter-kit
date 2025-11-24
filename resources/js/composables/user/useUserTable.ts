import {
    DataTableHeadActions,
    DataTableHeadCheckbox,
    DataTableRowActions,
    DataTableRowCheckbox,
} from '@/components/ui/custom/data-table-v2';
import { useDataTable, UseDataTableOptions, useDataTableTemplate } from '@/composables/data-table';
import { UserResource } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { h } from 'vue';

export function useUserTable({ data, actions = [] }: Omit<UseDataTableOptions<UserResource>, 'columns'>) {
    const [DefineFullNameCell, FullNameCell] = useDataTableTemplate<UserResource>();
    const [DefineEmailCell, EmailCell] = useDataTableTemplate<UserResource>();
    const [DefinePhoneCell, PhoneCell] = useDataTableTemplate<UserResource>();
    const [DefineDeletedAtCell, DeletedAtCell] = useDataTableTemplate<UserResource>();

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
                cell: (props) => h(FullNameCell, props),
            },
            {
                accessorKey: 'email',
                header: () => trans('models.user.fields.email'),
                cell: (props) => h(EmailCell, props),
            },
            {
                accessorKey: 'phone',
                header: () => trans('models.user.fields.phone'),
                cell: (props) => h(PhoneCell, props),
            },
            {
                accessorKey: 'deleted_at',
                header: () => trans('models.user.fields.deleted_at'),
                cell: (props) => h(DeletedAtCell, props),
            },
            {
                id: 'actions',
                header: (props) => h(DataTableHeadActions, props),
                cell: (props) => h(DataTableRowActions, props),
            },
        ],
    });

    return {
        ...table,
        defineCell: {
            fullName: DefineFullNameCell,
            email: DefineEmailCell,
            phone: DefinePhoneCell,
            deletedAt: DefineDeletedAtCell,
        },
    };
}
