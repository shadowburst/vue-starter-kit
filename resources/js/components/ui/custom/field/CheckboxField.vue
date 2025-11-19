<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import {
    FormControl,
    FormDescription,
    FormError,
    FormField,
    formFieldPropKeys,
    FormFieldProps,
    FormLabel,
} from '@/components/ui/custom/form';
import { reactiveOmit, reactivePick } from '@vueuse/core';
import { CheckboxRootProps, useForwardProps } from 'reka-ui';

defineOptions({
    inheritAttrs: false,
});

type Props = FormFieldProps & CheckboxRootProps;
const props = withDefaults(defineProps<Props>(), {
    orientation: 'horizontal',
    required: false,
});
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const model = defineModel<boolean | 'indeterminate'>();
</script>

<template>
    <FormField v-bind="forwardedFieldProps">
        <slot name="input">
            <FormControl>
                <Checkbox v-bind="{ ...$attrs, ...forwardedOtherProps }" v-model="model" />
            </FormControl>
        </slot>
        <slot name="label">
            <FormLabel />
        </slot>
        <slot name="description">
            <FormDescription />
        </slot>
        <slot name="error">
            <FormError />
        </slot>
    </FormField>
</template>
