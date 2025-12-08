<script setup lang="ts">
import { FieldDescription } from '@/components/ui/field';
import { injectFormFieldContext } from './FormField.vue';

const { description } = injectFormFieldContext();
</script>

<template>
    <FieldDescription v-if="description || $slots.default">
        <slot>
            {{ description }}
        </slot>
    </FieldDescription>
</template>
