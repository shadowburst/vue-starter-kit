<script lang="ts">
export type FormFieldProps = {
    id?: string;
    name?: string;
    label?: string;
    description?: string;
    errors?: Arrayable<string>;
    required?: boolean;
    disabled?: boolean;
    orientation?: FieldVariants['orientation'];
    class?: HTMLAttributes['class'];
};
type FormFieldContext = {
    id: Ref<string>;
    name: Ref<string>;
    label: Ref<string | undefined>;
    description: Ref<string | undefined>;
    errors: Ref<string[]>;
    required: Ref<boolean>;
    disabled: Ref<boolean>;
};

export const [injectFormFieldContext, provideFormFieldContext] = createContext<FormFieldContext>('FormFieldContext');

export const formFieldPropKeys = [
    'id',
    'name',
    'label',
    'description',
    'errors',
    'required',
    'disabled',
    'orientation',
    'class',
] as const;
</script>

<script setup lang="ts">
import { Field, FieldVariants } from '@/components/ui/field';
import { useArrayWrap } from '@/composables';
import { cn } from '@/lib/utils';
import { Arrayable, toRefs } from '@vueuse/core';
import { createContext } from 'reka-ui';
import { computed, HTMLAttributes, Ref, useId } from 'vue';
import { injectFormContext } from './Form.vue';

const props = withDefaults(defineProps<FormFieldProps>(), {
    id: () => useId(),
});

const { disabled: formDisabled } = injectFormContext();
const disabled = computed((): boolean => props.disabled || formDisabled.value);

const { id, label, description, required } = toRefs(props);
const name = computed((): string => props.name ?? id.value);
const errors = computed(() => useArrayWrap(props.errors).value.map((message) => message));

provideFormFieldContext({
    id,
    name,
    label,
    description,
    errors,
    required,
    disabled,
});
</script>

<template>
    <Field :orientation :data-invalid="errors.length > 0 || undefined" :class="cn('', props.class)">
        <slot />
    </Field>
</template>
