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
import { DateInput, DateInputProps } from '@/components/ui/custom/input';
import { reactiveOmit, reactivePick } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';

type Props = FormFieldProps & DateInputProps;
const props = defineProps<Props>();
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const model = defineModel<number>();
</script>

<template>
    <FormField v-bind="forwardedFieldProps">
        <slot>
            <FormLabel />
            <FormControl>
                <DateInput v-bind="forwardedOtherProps" v-model="model" />
            </FormControl>
            <FormDescription />
            <FormError />
        </slot>
    </FormField>
</template>
