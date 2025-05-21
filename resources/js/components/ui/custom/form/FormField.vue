<script lang="ts">
type FormFieldContext = {
    id: Ref<string>;
    name: Ref<string>;
    required: Ref<boolean>;
    disabled: Ref<boolean>;
    descriptionId: Ref<string>;
    errorId: Ref<string>;
    error: Ref<string | undefined>;
};

export const [injectFormFieldContext, provideFormFieldContext] = createContext<FormFieldContext>('FormFieldContext');
</script>

<script setup lang="ts">
import { cn } from '@/lib/utils';
import { toRefs } from '@vueuse/core';
import { createContext } from 'reka-ui';
import { computed, HTMLAttributes, ref, Ref, useId } from 'vue';

type Props = {
    id?: string;
    name?: string;
    required?: boolean;
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    id: () => useId(),
});

const { id, required, disabled } = toRefs(props);
const name = computed((): string => props.name ?? id.value);
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
});
</script>

<template>
    <div :class="cn('grid gap-1', props.class)">
        <slot />
    </div>
</template>
