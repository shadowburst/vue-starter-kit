import { FormDataType } from '@inertiajs/core';
import { cloneDeep } from 'lodash-es';
import { Reactive, reactive, toValue } from 'vue';

export function usePartialForm<TForm extends FormDataType<TForm>>(data: TForm | (() => TForm)) {
    type Form = Reactive<TForm>;
    type Key = keyof TForm;

    const dataValue = toValue(data);

    const form: Form = reactive(cloneDeep(dataValue));

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
