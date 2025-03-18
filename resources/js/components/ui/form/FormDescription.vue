<template>
    <p :id="field.descriptionId.value" :class="cn('text-sm text-muted-foreground', props.class)">
        <slot />
    </p>
</template>

<script lang="ts" setup>
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const field = injectFormFieldContext();
</script>
