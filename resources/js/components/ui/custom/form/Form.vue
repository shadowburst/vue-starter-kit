<script lang="ts">
export type FormContext<TForm extends FormDataType<TForm>> = {
    form: Ref<InertiaForm<TForm>>;
    disabled: Ref<boolean>;
    canSubmit: Ref<boolean>;
};
export function injectFormContext<TForm extends FormDataType<TForm>>(
    fallback?: FormContext<TForm>,
): FormContext<TForm> {
    const context = inject('FormContext', fallback);
    if (!context) {
        throw new Error(`Injection \`FormContext\` not found. Component must be used within a \`Form\``);
    }

    return context;
}
export function provideFormContext<TForm extends FormDataType<TForm>>(contextValue: FormContext<TForm>): void {
    return provide('FormContext', contextValue);
}
</script>

<script setup lang="ts" generic="TForm extends FormDataType<TForm>">
import { cn } from '@/lib/utils';
import { FormDataType } from '@/types';
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { computed, HTMLAttributes, inject, provide, Ref } from 'vue';

type Props = {
    form?: InertiaForm<TForm>;
    disabled?: boolean;
    canSubmit?: boolean;
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    form: () => useForm<TForm>({} as TForm),
    disabled: false,
    canSubmit: true,
});

type Emits = {
    submit: [];
};
defineEmits<Emits>();

const form = computed(() => props.form);
const disabled = computed(() => props.disabled);
const canSubmit = computed(() => props.canSubmit && !form.value.processing);

provideFormContext({
    form,
    disabled,
    canSubmit,
});
</script>

<template>
    <form :class="cn('', props.class)" @submit.prevent="$emit('submit')">
        <slot :form :disabled :can-submit />
    </form>
</template>
