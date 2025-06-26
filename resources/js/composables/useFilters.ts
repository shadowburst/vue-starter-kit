import { FormDataType } from '@/types';
import { router, VisitOptions } from '@inertiajs/core';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { reactiveOmit, toReactive, useDebounceFn, useSessionStorage } from '@vueuse/core';
import { isEqual } from 'es-toolkit';
import { computed, nextTick, watch, WatchOptions } from 'vue';

type FiltersParams<TForm extends FormDataType> = {
    [K in keyof TForm]: NonNullable<TForm[K]>;
};
type FiltersOptions<TForm extends FormDataType> = VisitOptions &
    WatchOptions & {
        transform?: (data: TForm) => TForm;
        onReload?: (key: (keyof TForm)[]) => void;
        debounceReload?: (key: (keyof TForm)[]) => boolean;
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
    if (typeof data !== 'function') {
        form.defaults(Object.keys(data).reduce((carry, key) => Object.assign(carry, { [key]: undefined }), {}));
    }
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

    const transform = options.transform ?? ((data) => data);

    const params = computed(
        (): FiltersParams<TForm> =>
            Object.entries(transform(form.data())).reduce((p, [key, value]) => {
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

    function reload(...keys: (keyof TForm)[]) {
        const currentRoute = route().current();
        if (!currentRoute) {
            return;
        }

        options.onReload?.(keys);

        const currentParams = reactiveOmit(route().params, ...Object.keys(transform(form.data())));

        router.visit(route(currentRoute, currentParams), {
            data: params.value,
            preserveScroll: true,
            preserveState: true,
            replace: true,
            ...options,
        });
    }

    const debouncedReload = useDebounceFn(reload, 500);

    watch(
        () => params.value,
        (newValue, oldValue) => {
            if (isEqual(newValue, oldValue)) {
                return;
            }

            const keys = Object.keys(newValue).filter(
                (key) => !isEqual(newValue[key], oldValue[key]),
            ) as (keyof TForm)[];

            if (options.debounceReload?.(keys) ?? true) {
                debouncedReload(...keys);
            } else {
                reload(...keys);
            }
        },
    );
    if (options.immediate) {
        nextTick(reload);
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

export function clearSessionFilters(url: string) {
    const remembered = useSessionStorage(url, {});
    remembered.value = undefined;
}
