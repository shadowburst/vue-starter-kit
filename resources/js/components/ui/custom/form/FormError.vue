<script setup lang="ts">
import { ErrorText } from '@/components/ui/custom/typeography';
import { watch } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = {
    message?: string;
};
const props = defineProps<Props>();

const { errorId, error } = injectFormFieldContext();

watch(
    () => props.message,
    () => (error.value = props.message),
    { immediate: true },
);
</script>

<template>
    <ErrorText v-if="error" :id="errorId">
        {{ error }}
    </ErrorText>
</template>
