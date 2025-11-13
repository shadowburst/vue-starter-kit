<script lang="ts">
export type TextInputProps = {
    type?: InputTypeHTMLAttribute;
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
export type TextInputEmits = {
    'update:modelValue': [string];
};
</script>

<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { useForwardExpose, useForwardPropsEmits } from 'reka-ui';
import { HTMLAttributes, InputTypeHTMLAttribute } from 'vue';
import PasswordInput from './PasswordInput.vue';
import SearchInput from './SearchInput.vue';

const { type = 'text', ...props } = defineProps<TextInputProps>();

const emits = defineEmits<TextInputEmits>();

const forwarded = useForwardPropsEmits(props, emits);

const { forwardRef } = useForwardExpose();
</script>

<template>
    <PasswordInput v-if="type === 'password'" v-bind="forwarded" :ref="forwardRef" />
    <SearchInput v-else-if="type === 'search'" v-bind="forwarded" :ref="forwardRef" />
    <Input v-else v-bind="forwarded" :type :ref="forwardRef" />
</template>
