<script setup lang="ts">
import {
    FormControl,
    FormDescription,
    FormError,
    FormField,
    FormFieldProps,
    FormLabel,
} from '@/components/ui/custom/form';
import { TextInput, TextInputProps } from '@/components/ui/custom/input';
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';

defineOptions({
    inheritAttrs: false,
});

type Props = FormFieldProps & TextInputProps;
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'type');
const forwarded = useForwardProps(delegatedProps);

const model = defineModel<string>();
</script>

<template>
    <FormField v-bind="forwarded">
        <slot name="label">
            <FormLabel />
        </slot>
        <slot name="input">
            <FormControl>
                <TextInput v-bind="{ ...$attrs }" v-model="model" :type />
            </FormControl>
        </slot>
        <slot name="description">
            <FormDescription />
        </slot>
        <slot name="error">
            <FormError />
        </slot>
    </FormField>
</template>
