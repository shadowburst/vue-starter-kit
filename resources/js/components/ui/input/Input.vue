<script setup lang="ts">
import { useForwardExpose, useForwardPropsEmits } from 'reka-ui';
import BaseInput from './BaseInput.vue';
import { InputEmits, InputProps } from './interface';
import PasswordInput from './PasswordInput.vue';

const { type = 'text', ...props } = defineProps<InputProps>();

const emits = defineEmits<InputEmits>();

const forwarded = useForwardPropsEmits(props, emits);

const { forwardRef } = useForwardExpose();
</script>

<template>
    <PasswordInput v-if="type === 'password'" v-bind="forwarded" :ref="forwardRef" />
    <BaseInput v-else v-bind="forwarded" :type :ref="forwardRef" />
</template>
