<script setup lang="ts">
import {
    FormControl,
    FormDescription,
    FormError,
    FormField,
    formFieldPropKeys,
    FormFieldProps,
    FormLabel,
} from '@/components/ui/custom/form';
import { Textarea } from '@/components/ui/textarea';
import { reactiveOmit, reactivePick } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';

defineOptions({
    inheritAttrs: false,
});

type Props = FormFieldProps & {
    defaultValue?: string;
    maxlength?: number;
};
const props = withDefaults(defineProps<Props>(), {
    maxlength: 1500,
});
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const model = defineModel<string>();
</script>

<template>
    <FormField v-bind="forwardedFieldProps">
        <slot name="label">
            <FormLabel />
        </slot>
        <slot name="input">
            <FormControl>
                <Textarea v-bind="{ ...$attrs, ...forwardedOtherProps }" v-model="model" />
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
