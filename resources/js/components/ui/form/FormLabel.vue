<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import { LabelProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = LabelProps & {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const field = injectFormFieldContext();
</script>

<template>
    <Label
        :for="props.for ?? field.id.value"
        :aria-required="field.required.value"
        :class="
            cn(
                `aria-required:after:text-destructive block first-letter:uppercase aria-required:after:content-['_*']`,
                props.class,
            )
        "
    >
        <slot />
    </Label>
</template>
