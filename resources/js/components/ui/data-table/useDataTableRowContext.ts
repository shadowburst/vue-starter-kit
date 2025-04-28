import { inject, provide, Ref } from 'vue';

export type DataTableRowContext<TData extends object> = {
    item: Ref<TData>;
    isSelected: Ref<boolean>;
    toggleSelected: (value: boolean) => void;
};

export function useDataTableRowContext<TData extends object>(
    fallback?: DataTableRowContext<TData>,
): DataTableRowContext<TData> {
    const context = inject('dataTableRowContext', fallback);

    if (!context) {
        throw new Error(`Injection \`dataTableRowContext\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRowContext<TData extends object>(contextValue: DataTableRowContext<TData>) {
    return provide('dataTableRowContext', contextValue);
}
