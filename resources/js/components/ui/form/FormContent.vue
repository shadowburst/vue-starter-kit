<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Primitive, PrimitiveProps } from 'reka-ui';
import { computed, HTMLAttributes } from 'vue';

type Props = PrimitiveProps & {
    class?: HTMLAttributes['class'];
};
const { as = 'div', ...props } = defineProps<Props>();

const forwarded = computed(() => ({
    ...props,
    as,
    class: undefined,
}));
</script>

<template>
    <Primitive v-bind="forwarded" :class="cn('grid gap-4', props.class)">
        <slot />
    </Primitive>
</template>
