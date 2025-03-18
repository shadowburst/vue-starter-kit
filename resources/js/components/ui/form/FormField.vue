<template>
    <div :class="cn('grid gap-2', props.class)">
        <slot />
    </div>
</template>

<script lang="ts">
import { createContext } from 'reka-ui';

type FormFieldContext = {
    id: Ref<string>;
    name: Ref<string>;
    required: Ref<boolean>;
    disabled: Ref<boolean>;
    descriptionId: Ref<string>;
    errorId: Ref<string>;
    error: Ref<string | undefined>;
    handleError: (value?: string) => void;
};

export const [injectFormFieldContext, provideFormFieldContext] = createContext<FormFieldContext>('FormFieldContext');
</script>

<script setup lang="ts">
import { cn } from '@/lib/utils';
import { computed, HTMLAttributes, ref, Ref, useId } from 'vue';

type Props = {
    name: string;
    id?: string;
    required?: boolean;
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const id = computed((): string => props.id ?? useId());
const name = computed((): string => props.name);
const required = computed((): boolean => props.required);
const disabled = computed((): boolean => props.disabled);
const descriptionId = computed((): string => `${id.value}-description`);
const errorId = computed((): string => `${id.value}-error`);
const error = ref<string>();

provideFormFieldContext({
    id,
    name,
    required,
    disabled,
    descriptionId,
    errorId,
    error,
    handleError(value?: string) {
        error.value = value;
    },
});
</script>
