<script setup lang="ts">
import { FieldDescription, FieldLabel, FieldSet } from '@/components/ui/field';
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

type Props = {
    title?: string;
    description?: string;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <FieldSet :class="cn('', props.class)">
        <FieldLabel v-if="props.title">
            {{ props.title }}
        </FieldLabel>
        <FieldDescription v-if="props.description">
            {{ props.description }}
        </FieldDescription>
        <slot />
    </FieldSet>
</template>
