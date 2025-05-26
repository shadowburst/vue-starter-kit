import { FormDataConvertible, router, VisitOptions } from '@inertiajs/core';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { toReactive } from '@vueuse/core';
import { debounce, isEqual } from 'es-toolkit';
import { computed, watch } from 'vue';

type FormDataType = Record<string, FormDataConvertible>;
type FiltersParams = Record<string, NonNullable<any>>;
type FiltersForm<TForm extends FormDataType> = InertiaForm<TForm> & {
    params: FiltersParams;
};
type TransformCallback<TForm extends FormDataType> = (data: TForm) => Record<string, FormDataConvertible>;

export default function useFilters<TForm extends FormDataType>(
    data: TForm | (() => TForm),
    options?: VisitOptions,
): FiltersForm<TForm>;
export default function useFilters<TForm extends FormDataType>(
    rememberKey: string,
    data: TForm | (() => TForm),
    options?: VisitOptions,
): FiltersForm<TForm>;
export function useFilters<TForm extends FormDataType>(
    rememberKeyOrData: string | TForm | (() => TForm),
    maybeDataOrOptions?: TForm | (() => TForm) | VisitOptions,
    maybeOptions: VisitOptions = {},
): FiltersForm<TForm> {
    const rememberKey = typeof rememberKeyOrData === 'string' ? rememberKeyOrData : null;
    const data = (typeof rememberKeyOrData === 'string' ? maybeDataOrOptions : rememberKeyOrData) as
        | TForm
        | (() => TForm);
    const options = (typeof rememberKeyOrData === 'string' ? maybeOptions : maybeDataOrOptions) as VisitOptions;

    const form = rememberKey ? useForm(rememberKey, data) : useForm(data);

    let transform: TransformCallback<TForm> = (data: TForm) => data;

    const computedParams = computed(() => {
        return Object.entries(transform(form.data())).reduce((total, [key, value]) => {
            if (value == undefined) {
                return total;
            }
            if (Array.isArray(value) && !value.length) {
                return total;
            }
            if (typeof value === 'string' && !value) {
                return total;
            }
            return Object.assign(total, { [key]: value });
        }, {} as FiltersParams);
    });
    const params = toReactive(computedParams);

    function reload(queryParams: FiltersParams = params) {
        const currentRoute = route().current();
        if (!currentRoute) {
            return;
        }

        router.visit(route(currentRoute, queryParams), {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            ...options,
        });
    }

    const hasPage = form.page != undefined;
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

            let queryParams = newParams;

            pause();
            if (hasPage && newParams.page === oldParams.page) {
                //@ts-expect-error
                form.page = 1;
                queryParams = transform(form.data());
            }
            resume();

            reload(queryParams);
        }, 500),

        { deep: true },
    );

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
