import { FormDataConvertible, router, VisitOptions } from '@inertiajs/core';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { debouncedWatch, toReactive } from '@vueuse/core';
import { computed } from 'vue';

type FormDataType = Record<string, FormDataConvertible>;
type FiltersForm<TForm extends FormDataType> = InertiaForm<TForm> & {
    params: Record<string, NonNullable<any>>;
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
        return Object.entries(transform(form.data())).reduce(
            (total, [key, value]) => {
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
            },
            {} as Record<string, any>,
        );
    });
    const params = toReactive(computedParams);

    debouncedWatch(
        params,
        (newParams) => {
            const currentRoute = route().current();
            if (!currentRoute) {
                return;
            }

            router.visit(route(currentRoute, newParams), {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                ...options,
            });
        },
        { debounce: 500 },
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
