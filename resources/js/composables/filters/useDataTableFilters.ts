import { FormDataKeys, FormDataType, UrlMethodPair, UseFormSubmitOptions } from '@inertiajs/core';
import { InertiaForm } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { watch } from 'vue';
import { useFilters } from './useFilters';

type DataTableFilters = {
    q?: string;
    page?: number;
    per_page?: number;
    sort_by?: string;
    sort_direction?: 'asc' | 'desc';
};
const dataTableFields: (keyof DataTableFilters)[] = ['q', 'page', 'per_page', 'sort_by', 'sort_direction'];

export function useDataTableFilters<
    TForm extends FormDataType<DataTableFilters> &
        FormDataType<{ [K in keyof Omit<TForm, keyof DataTableFilters>]: TForm[K] | undefined }>,
>(
    urlMethodPair: UrlMethodPair | (() => UrlMethodPair),
    data: TForm | (() => TForm),
    options: UseFormSubmitOptions = {},
): InertiaForm<TForm> {
    const filters = useFilters(urlMethodPair, data);

    const resetPage = useDebounceFn(() => {
        if (filters.page === 1) {
            filters.submit(options);
        } else {
            filters.page = 1;
        }
    }, 350);

    // Whenever a filter changes, reset to page 1 and reload with debounce
    // If changing page, just submit immediately
    watch(
        () => filters.data(),
        (newData, oldData) => {
            if (newData.page === oldData?.page) {
                resetPage();
                return;
            }
            filters.submit(options);
        },
        { immediate: true, deep: true },
    );

    const proxy = new Proxy(filters, {
        get(target, prop, receiver) {
            switch (prop) {
                // When resetting, we want to keep pagination and sorting fields
                case 'reset':
                    return (...fields: FormDataKeys<TForm>[]) => {
                        if (fields.length > 0) {
                            target.reset(...fields);
                            return proxy;
                        }

                        target.reset(
                            ...(Object.keys(target.data()).filter(
                                (key) => !(dataTableFields as string[]).includes(key),
                            ) as FormDataKeys<TForm>[]),
                        );
                        return proxy;
                    };
                case 'isDirty':
                    for (const [key, value] of Object.entries(target.data())) {
                        if (value == undefined) {
                            continue;
                        }
                        if (Array.isArray(value) && !value.length) {
                            continue;
                        }
                        if (typeof value === 'string' && value.trim() === '') {
                            continue;
                        }
                        if ((dataTableFields as string[]).includes(key)) {
                            continue;
                        }
                        return true;
                    }
                    return false;

                default:
                    return Reflect.get(target, prop, receiver);
            }
        },
    });

    return proxy;
}
