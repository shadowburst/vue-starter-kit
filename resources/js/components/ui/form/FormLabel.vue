<template>
    <Label
        :for="props.for ?? field.id.value"
        :aria-required="field.required.value"
        :class="
            cn(
                `flex items-center gap-2 aria-required:after:text-destructive aria-required:after:content-['_*']`,
                props.class,
            )
        "
    >
        <slot />
    </Label>
</template>

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
