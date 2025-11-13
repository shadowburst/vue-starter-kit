<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import {
    FormControl,
    FormDescription,
    FormError,
    FormField,
    FormFieldProps,
    FormLabel,
} from '@/components/ui/custom/form';
import { reactiveOmit } from '@vueuse/core';
import { CheckboxRootProps, useForwardProps } from 'reka-ui';

defineOptions({
    inheritAttrs: false,
});

type Props = FormFieldProps & CheckboxRootProps;
const props = withDefaults(defineProps<Props>(), {
    orientation: 'horizontal',
    required: false,
});
const delegatedProps = reactiveOmit(props, 'defaultValue', 'value', 'modelValue');
const forwarded = useForwardProps(delegatedProps);

const model = defineModel<boolean | 'indeterminate'>();
</script>

<template>
    <FormField v-bind="forwarded">
        <slot name="input">
            <FormControl>
                <Checkbox v-bind="{ ...$attrs }" v-model="model" :default-value :value />
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
