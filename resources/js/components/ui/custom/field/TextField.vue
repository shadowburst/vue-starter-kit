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
import { TextInput, TextInputProps } from '@/components/ui/custom/input';
import { reactiveOmit, reactivePick } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';

type Props = FormFieldProps &
    TextInputProps & {
        maxlength?: number;
    };
const props = withDefaults(defineProps<Props>(), {
    maxlength: 255,
});
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const model = defineModel<string>();
</script>

<template>
    <FormField v-bind="forwardedFieldProps">
        <slot>
            <FormLabel />
            <FormControl>
                <TextInput v-bind="forwardedOtherProps" v-model="model" />
            </FormControl>
            <FormDescription />
            <FormError />
        </slot>
    </FormField>
</template>
