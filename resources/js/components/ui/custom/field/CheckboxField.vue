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
import { CheckboxCheckedState, CheckboxRootProps, useForwardProps } from 'reka-ui';

type Props = FormFieldProps & CheckboxRootProps;
const props = withDefaults(defineProps<Props>(), {
    orientation: 'horizontal',
    required: false,
});
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const model = defineModel<CheckboxCheckedState>();
</script>

<template>
    <FormField v-bind="forwardedFieldProps">
        <slot>
            <FormControl>
                <Checkbox v-bind="forwardedOtherProps" v-model="model" />
            </FormControl>
            <FormLabel />
            <FormDescription />
            <FormError />
        </slot>
    </FormField>
</template>
