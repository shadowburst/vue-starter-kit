import { FormDataType, UrlMethodPair } from '@inertiajs/core';
import { InertiaPrecognitiveForm, useForm } from '@inertiajs/vue3';
import { toValue } from 'vue';

export function usePageForm<TForm extends FormDataType<TForm>>(
    urlMethodPair: UrlMethodPair | (() => UrlMethodPair),
    data: TForm | (() => TForm),
) {
    type Form = InertiaPrecognitiveForm<TForm>;
    type Key = keyof TForm;

    const dataValue = toValue(data);

    const form: Form = useForm(urlMethodPair, data);

    const proxy = new Proxy(form, {});

    Object.keys(dataValue).forEach((field: string) => {
        const key = field as Key;

        const descriptor = Object.getOwnPropertyDescriptor(dataValue, key);

        if (!descriptor) {
            return;
        }

        Object.defineProperty(proxy, key, descriptor);
    });

    return proxy;
}
