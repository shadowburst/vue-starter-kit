<script setup lang="ts">
import { Slot } from 'reka-ui';
import { injectFormFieldContext } from './FormField.vue';

const field = injectFormFieldContext();
</script>

<template>
    <Slot
        :id="field.id.value"
        :name="field.name.value"
        :required="field.required.value"
        :disabled="field.disabled.value"
        :aria-describedby="
            !field.error.value ? `${field.descriptionId.value}` : `${field.descriptionId.value} ${field.errorId.value}`
        "
        :aria-invalid="!!field.error.value"
    >
        <slot />
    </Slot>
</template>
