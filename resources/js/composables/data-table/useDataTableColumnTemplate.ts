import { CellContext } from '@tanstack/vue-table';
import { createReusableTemplate } from '@vueuse/core';

export function useDataTableTemplate<TData>() {
    return createReusableTemplate<CellContext<TData, unknown>>({
        inheritAttrs: false,
    });
}

export type UseDataTableTemplateReturn<TData> = ReturnType<typeof useDataTableTemplate<TData>>;
export type DataTableTemplateDefinition<TData> = UseDataTableTemplateReturn<TData>['define'];
