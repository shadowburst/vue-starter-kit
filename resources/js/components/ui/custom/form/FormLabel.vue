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

const { id, required } = injectFormFieldContext();
</script>

<template>
    <Label
        :for="props.for ?? id"
        :aria-required="required"
        :class="
            cn(
                `aria-required:after:text-destructive text-xs font-medium first-letter:uppercase aria-required:after:content-['_*']`,
                props.class,
            )
        "
    >
        <slot />
    </Label>
</template>
