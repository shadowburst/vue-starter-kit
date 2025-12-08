<script setup lang="ts">
import { Slot } from 'reka-ui';
import { injectFormFieldContext } from './FormField.vue';

const { id, name, required, disabled, errors, attrs } = injectFormFieldContext();
</script>

<template>
    <Slot :id :name :required :disabled :aria-invalid="errors.length > 0 ? true : undefined" v-bind="attrs">
        <slot />
    </Slot>
</template>
