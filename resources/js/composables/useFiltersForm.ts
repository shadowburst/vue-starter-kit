import { FormDataType } from '@/types';
import { router, VisitOptions } from '@inertiajs/core';
import { InertiaForm } from '@inertiajs/vue3';
import { reactiveOmit, syncRefs, useSessionStorage, useUrlSearchParams } from '@vueuse/core';
import { ref } from 'vue';
import { useComputedForm } from './useComputedForm';

type TransformCallback<TForm> = (data: TForm) => object;
type FormOptions = Omit<VisitOptions, 'data'>;
type UseFiltersFormReturn<TForm extends FormDataType<TForm>> = {
    filters: InertiaForm<TForm>;
    reload: (options?: FormOptions) => void;
};

export function useFiltersForm<TForm extends FormDataType<TForm>>(
    data: TForm,
    defaultOptions: FormOptions = {},
): UseFiltersFormReturn<TForm> {
    const currentRoute = route().current();
    if (!currentRoute) {
        throw new Error('UseFiltersForm must be used within a valid route context.');
    }

    const transform = ref<TransformCallback<TForm>>((data) => data);

    const filters = useComputedForm(data);

    if (route().params.reset_filters) {
        useSessionStorage(currentRoute, {}, { flush: 'sync' }).value = undefined;
    }

    const remembered = useSessionStorage(currentRoute, filters.data(), {
        mergeDefaults: true,
    });
    Object.assign(filters, {
        ...remembered.value,
    });
    syncRefs(() => transform.value(filters.data()), remembered, {
        deep: true,
        immediate: true,
    });

    filters.transform = (callback: TransformCallback<TForm>) => {
        transform.value = callback;
        return filters;
    };

    const reload = (options: FormOptions = {}) => {
        const data = Object.entries(transform.value(filters.data())).reduce(
            (p, [key, value]) => {
                if (value == undefined) {
                    return p;
                }
                if (Array.isArray(value) && !value.length) {
                    return p;
                }
                if (typeof value === 'string' && value.trim() === '') {
                    return p;
                }
                return Object.assign(p, { [key]: value });
            },
            {} as Record<string, any>,
        );

        const urlSearchParams = reactiveOmit(useUrlSearchParams('history'), 'reset_filters', ...Object.keys(data));

        router.visit(route(currentRoute, urlSearchParams), {
            data,
            preserveScroll: true,
            preserveState: true,
            replace: true,
            ...defaultOptions,
            ...options,
        });
    };

    return { filters, reload };
}
