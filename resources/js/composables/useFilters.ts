import { FormDataType } from '@/types';
import { FormDataConvertible, router, VisitOptions } from '@inertiajs/core';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { toReactive, useSessionStorage } from '@vueuse/core';
import { debounce, isEqual } from 'es-toolkit';
import { computed, watch, WatchOptions } from 'vue';

type FiltersOptions = VisitOptions & WatchOptions & {};
type FiltersParams = Record<string, NonNullable<any>>;
export type FiltersForm<TForm extends FormDataType> = InertiaForm<TForm> & {
    params: FiltersParams;
};
type TransformCallback<TForm extends FormDataType> = (data: TForm) => Record<string, FormDataConvertible>;

export default function useFilters<TForm extends FormDataType>(
    data: TForm | (() => TForm),
    options?: FiltersOptions,
): FiltersForm<TForm>;
export default function useFilters<TForm extends FormDataType>(
    rememberKey: string,
    data: TForm | (() => TForm),
    options?: FiltersOptions,
): FiltersForm<TForm>;
export function useFilters<TForm extends FormDataType>(
    rememberKeyOrData: string | TForm | (() => TForm),
    maybeDataOrOptions?: TForm | (() => TForm) | FiltersOptions,
    maybeOptions: FiltersOptions = {},
): FiltersForm<TForm> {
    const rememberKey = typeof rememberKeyOrData === 'string' ? rememberKeyOrData : null;
    const data = (typeof rememberKeyOrData === 'string' ? maybeDataOrOptions : rememberKeyOrData) as
        | TForm
        | (() => TForm);
    const options = (typeof rememberKeyOrData === 'string' ? maybeOptions : maybeDataOrOptions) as FiltersOptions;

    const form = useForm(data);
    if (rememberKey) {
        const remembered = useSessionStorage(rememberKey, form.data(), { mergeDefaults: true });
        watch(
            () => form.data(),
            () => {
                console.log('remembered', form.data());
                remembered.value = form.data();
            },
        );
        Object.assign(form, { ...remembered.value });
    }

    let transform: TransformCallback<TForm> = (data: TForm) => data;

    const computedParams = computed(() => {
        return Object.entries(transform(form.data())).reduce((total, [key, value]) => {
            if (value == undefined) {
                return total;
            }
            if (Array.isArray(value) && !value.length) {
                return total;
            }
            if (typeof value === 'string' && value.trim() === '') {
                return total;
            }
            return Object.assign(total, { [key]: value });
        }, {} as FiltersParams);
    });
    const params = toReactive(computedParams);

    function reload() {
        const currentRoute = route().current();
        if (!currentRoute) {
            return;
        }

        router.visit(route(currentRoute, params), {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            ...options,
        });
    }

    const hasPage = 'page' in form;
    if (hasPage) {
        watch(
            () => form.page,
            () => {
                reload();
            },
        );
    }
    const { pause, resume } = watch(
        computedParams,
        debounce((newParams, oldParams) => {
            if (isEqual(newParams, oldParams)) {
                return;
            }

            pause();
            if (hasPage && newParams.page === oldParams.page) {
                //@ts-expect-error
                form.page = 1;
            }
            resume();

            reload();
        }, 500),

        { deep: true },
    );

    if (options.immediate) {
        reload();
    }

    return new Proxy(form, {
        get(target, prop) {
            switch (prop) {
                case 'params':
                    return params;
                case 'transform':
                    return (callback: TransformCallback<TForm>) => {
                        transform = callback;
                        return target;
                    };
                default:
                    //@ts-expect-error
                    return target[prop];
            }
        },
    }) as FiltersForm<TForm>;
}
