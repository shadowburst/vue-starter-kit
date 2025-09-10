import { FormDataType } from '@/types';
import { InertiaForm, useForm } from '@inertiajs/vue3';

/**
 * Creates a new Inertia form that allows computed properties.
 */
export function useComputedForm<TForm extends FormDataType<TForm>>(data: TForm): InertiaForm<TForm> {
    type Form = InertiaForm<TForm>;
    type Key = keyof TForm;

    const form: Form = useForm({ ...data });

    const proxy = new Proxy(form, {});

    Object.keys(data).forEach((field: string) => {
        const key = field as Key;

        const descriptor = Object.getOwnPropertyDescriptor(data, key);

        if (!descriptor) {
            return;
        }

        Object.defineProperty(proxy, key, descriptor);
    });

    return proxy;
}
