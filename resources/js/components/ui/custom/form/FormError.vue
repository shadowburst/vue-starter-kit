<script setup lang="ts">
import { FieldError } from '@/components/ui/field';
import { useArrayMap } from '@vueuse/core';
import { injectFormFieldContext } from './FormField.vue';

const formContext = injectFormFieldContext();
const errors = useArrayMap(
    () => formContext.errors.value,
    (message) => ({ message }),
);
</script>

<template>
    <FieldError :errors />
</template>
