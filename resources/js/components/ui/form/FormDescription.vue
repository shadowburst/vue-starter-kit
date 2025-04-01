<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const field = injectFormFieldContext();
</script>

<template>
    <p :id="field.descriptionId.value" :class="cn('text-muted-foreground text-sm', props.class)">
        <slot />
    </p>
</template>
