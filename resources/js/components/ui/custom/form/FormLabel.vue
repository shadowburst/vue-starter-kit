<script setup lang="ts">
import { CapitalizeText } from '@/components/ui/custom/typography';
import { FieldLabel } from '@/components/ui/field';
import { cn } from '@/lib/utils';
import { LabelProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectFormFieldContext } from './FormField.vue';

type Props = LabelProps & {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { id, label, required } = injectFormFieldContext();
</script>

<template>
    <FieldLabel
        v-if="label || $slots.default"
        :for="props.for ?? id"
        :aria-required="required"
        :class="cn('gap-1', props.class)"
    >
        <slot>
            <CapitalizeText>
                {{ label }}
            </CapitalizeText>
            <span v-if="required !== false" class="text-muted-foreground text-xs italic">
                ({{ $t(required ? 'required' : 'optional') }})
            </span>
        </slot>
    </FieldLabel>
</template>
