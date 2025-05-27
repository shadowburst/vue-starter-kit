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
                `not-[&:has([role=checkbox])]:aria-required:after:text-destructive gap-1 text-xs font-medium not-[&:has([role=checkbox])]:aria-required:after:content-['*'] [&:has([role=checkbox])]:gap-2`,
                props.class,
            )
        "
    >
        <slot />
    </Label>
</template>
