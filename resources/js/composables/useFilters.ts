import { FormDataType } from '@/types';
import { router, VisitOptions } from '@inertiajs/core';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { toReactive, useDebounceFn, useSessionStorage } from '@vueuse/core';
import { isEqual } from 'es-toolkit';
import { computed, watch, WatchOptions } from 'vue';

type FiltersParams<TForm extends FormDataType> = {
    [K in keyof TForm]: NonNullable<TForm[K]>;
};
type FiltersOptions<TForm extends FormDataType> = VisitOptions &
    WatchOptions & {
        onReload?: (key: keyof TForm) => void;
        debounceReload?: (key: keyof TForm) => boolean;
    };
export type FiltersForm<TForm extends FormDataType> = InertiaForm<TForm> & {
    params: FiltersParams<TForm>;
};

export default function useFilters<TForm extends FormDataType>(
    data: TForm | (() => TForm),
    options?: FiltersOptions<TForm>,
): FiltersForm<TForm>;
export default function useFilters<TForm extends FormDataType>(
    rememberKey: string,
    data: TForm | (() => TForm),
    options?: FiltersOptions<TForm>,
): FiltersForm<TForm>;
export function useFilters<TForm extends FormDataType>(
    rememberKeyOrData: string | TForm | (() => TForm),
    maybeDataOrOptions?: TForm | (() => TForm) | FiltersOptions<TForm>,
    maybeOptions: FiltersOptions<TForm> = {},
): FiltersForm<TForm> {
    const rememberKey = typeof rememberKeyOrData === 'string' ? rememberKeyOrData : null;
    const data = (typeof rememberKeyOrData === 'string' ? maybeDataOrOptions : rememberKeyOrData) as
        | TForm
        | (() => TForm);
    const options = (
        typeof rememberKeyOrData === 'string' ? maybeOptions : maybeDataOrOptions
    ) as FiltersOptions<TForm>;

    const form = useForm(data);
    if (rememberKey) {
        const remembered = useSessionStorage(rememberKey, form.data(), { mergeDefaults: true });
        watch(
            () => form.data(),
            (value) => {
                remembered.value = value;
            },
        );
        Object.assign(form, { ...remembered.value });
    }

    const params = computed(
        (): FiltersParams<TForm> =>
            Object.entries(form.data()).reduce((p, [key, value]) => {
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
            }, {}) as FiltersParams<TForm>,
    );

    function reload(key?: keyof TForm) {
        const currentRoute = route().current();
        if (!currentRoute) {
            return;
        }

        if (key) {
            options.onReload?.(key);
        }

        router.visit(route(currentRoute, params.value), {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            ...options,
        });
    }

    const debouncedReload = useDebounceFn(reload, 500);

    for (const key in form.data()) {
        watch(
            () => params.value[key],
            (newValue, oldValue) => {
                if (isEqual(newValue, oldValue)) {
                    return;
                }

                if (options.debounceReload?.(key) ?? true) {
                    debouncedReload(key);
                } else {
                    reload(key);
                }
            },
        );
    }
    if (options.immediate) {
        reload();
    }

    const override = {
        params: toReactive(params),
    };

    return new Proxy(form, {
        get(target, prop) {
            switch (prop) {
                case 'params':
                    return override.params;
                default:
                    return target[prop as keyof typeof target];
            }
        },
    }) as FiltersForm<TForm>;
}
