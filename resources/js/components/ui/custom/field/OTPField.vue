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
import { InputOTP, InputOTPGroup, InputOTPSlot } from '@/components/ui/input-otp';
import { reactiveOmit, reactivePick } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';
import { computed } from 'vue';
import { REGEXP_ONLY_DIGITS, type OTPInputProps } from 'vue-input-otp';

type Props = FormFieldProps & Partial<OTPInputProps>;
const props = withDefaults(defineProps<Props>(), {
    maxlength: 6,
    pattern: REGEXP_ONLY_DIGITS,
});
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const slots = computed(() => Array.from({ length: props.maxlength }, (_, i) => i));
const model = defineModel<string>({
    default: '',
});
</script>

<template>
    <FormField v-bind="forwardedFieldProps">
        <slot>
            <FormLabel />
            <FormControl>
                <InputOTP v-bind="forwardedOtherProps" v-model="model">
                    <InputOTPGroup>
                        <InputOTPSlot v-for="index in slots" :key="index" :index />
                    </InputOTPGroup>
                </InputOTP>
            </FormControl>
            <FormDescription />
            <FormError />
        </slot>
    </FormField>
</template>
