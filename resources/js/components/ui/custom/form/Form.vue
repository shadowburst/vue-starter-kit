<script lang="ts">
export function injectFormContext<TForm extends FormDataType>(fallback?: InertiaForm<TForm>): InertiaForm<TForm> {
    const context = inject('FormContext', fallback);

    if (!context) {
        throw new Error(`Injection \`FormContext\` not found. Component must be used within a \`Form\``);
    }

    return context;
}
export function provideFormContext<TForm extends FormDataType>(contextValue: InertiaForm<TForm>) {
    return provide('FormContext', contextValue);
}
</script>

<script setup lang="ts" generic="TForm extends FormDataType">
import { cn } from '@/lib/utils';
import { FormDataType } from '@/types';
import { InertiaForm } from '@inertiajs/vue3';
import { HTMLAttributes, inject, provide } from 'vue';

type Props = {
    form?: InertiaForm<TForm>;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

type Emits = {
    submit: [];
};
defineEmits<Emits>();

if (props.form) {
    provideFormContext(props.form);
}
</script>

<template>
    <form :class="cn('', props.class)" @submit.prevent="$emit('submit')">
        <slot />
    </form>
</template>
