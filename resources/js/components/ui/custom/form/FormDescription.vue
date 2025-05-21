<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { descriptionId } = injectFormFieldContext();
</script>

<template>
    <p :id="descriptionId" :class="cn('text-muted-foreground text-sm', props.class)">
        <slot />
    </p>
</template>
