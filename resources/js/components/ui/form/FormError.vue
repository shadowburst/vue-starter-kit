<script setup lang="ts">
import { cn } from '@/lib/utils';
import { HTMLAttributes, watch } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = {
    message?: string;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const field = injectFormFieldContext();

watch(
    () => props.message,
    () => field.handleError(props.message),
    { immediate: true },
);
</script>

<template>
    <p v-if="message" :id="field.errorId.value" :class="cn('text-sm text-red-600 dark:text-red-500', props.class)">
        {{ message }}
    </p>
</template>
