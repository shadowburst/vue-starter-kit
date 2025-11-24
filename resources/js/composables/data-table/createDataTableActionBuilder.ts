import type {
    DataTableCallbackAction,
    DataTableCustomAction,
    DataTableHrefAction,
    DataTableMultiAction,
} from '@/components/ui/custom/data-table-v2';

export function createDataTableActionHelper<T>() {
    return {
        href(options: Omit<DataTableHrefAction<T>, 'type'>): DataTableHrefAction<T> {
            return {
                type: 'href',
                ...options,
            };
        },
        callback(options: Omit<DataTableCallbackAction<T>, 'type'>): DataTableCallbackAction<T> {
            return {
                type: 'callback',
                ...options,
            };
        },
        custom(options: Omit<DataTableCustomAction<T>, 'type'>): DataTableCustomAction<T> {
            return {
                type: 'custom',
                ...options,
            };
        },
        multi(options: Omit<DataTableMultiAction<T[]>, 'type'>): DataTableMultiAction<T[]> {
            return {
                type: 'multi',
                ...options,
            };
        },
    };
}
