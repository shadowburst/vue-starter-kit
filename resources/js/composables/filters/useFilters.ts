import { FormDataType, router, UrlMethodPair, UseFormTransformCallback, UseFormUtils } from '@inertiajs/core';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { syncRefs, useSessionStorage, useUrlSearchParams } from '@vueuse/core';
import { ref, toValue } from 'vue';

export function useFilters<TForm extends FormDataType<{ [K in keyof TForm]: TForm[K] | undefined }>>(
    urlMethodPair: UrlMethodPair | (() => UrlMethodPair),
    data: TForm | (() => TForm),
): InertiaForm<TForm> {
    // If we call reset later we want to clear all fields, so we initialize them with undefined
    const filters = useForm<TForm>(
        Object.keys(toValue(data)).reduce(
            (carry, key) => Object.assign(carry, { [key]: undefined }),
            {} as Partial<TForm>,
        ) as TForm,
    );

    // Must be reactive to update storage if changed
    const transform = ref<UseFormTransformCallback<TForm>>((data) => data);
    filters.transform = (callback) => {
        transform.value = callback;
        return filters;
    };

    const storageKey = toValue(urlMethodPair).url.split('?')[0];

    // Allow clearing filters via URL param
    const urlParams = useUrlSearchParams('history');
    if (urlParams.reset_filters) {
        useSessionStorage(storageKey, {}, { flush: 'sync' }).value = undefined;
    }

    // Restore previous values from session and keep in sync
    // Link storage key to given URL without query params
    const remembered = useSessionStorage(storageKey, filters.data(), {
        mergeDefaults: true,
    });
    Object.assign(filters, {
        ...remembered.value,
    });
    syncRefs(() => transform.value(filters.data()), remembered, {
        deep: true,
        immediate: true,
    });

    // Handle form submission manually to add some default behavior
    filters.submit = (...args) => {
        const { options } = UseFormUtils.parseSubmitArguments(args, () => toValue(urlMethodPair));
        const query = Object.entries(transform.value(filters.data())).reduce(
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

        router.visit(toValue(urlMethodPair), {
            data: query,
            preserveScroll: true,
            preserveState: true,
            replace: true,
            ...options,
        });
    };

    return filters;
}
