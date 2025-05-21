<script setup lang="ts">
import { Slot } from 'reka-ui';
import { injectFormFieldContext } from './FormField.vue';

const { id, name, required, disabled, error, descriptionId, errorId } = injectFormFieldContext();
</script>

<template>
    <Slot
        :id
        :name
        :required
        :disabled
        :aria-describedby="!error ? `${descriptionId}` : `${descriptionId} ${errorId}`"
        :aria-invalid="!!error"
    >
        <slot />
    </Slot>
</template>
