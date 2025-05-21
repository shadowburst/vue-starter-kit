<script setup lang="ts">
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { Toggle, type ToggleEmits, type ToggleProps, useForwardPropsEmits } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import { type ToggleVariants, toggleVariants } from '.';

const props = withDefaults(
    defineProps<
        ToggleProps & {
            class?: HTMLAttributes['class'];
            variant?: ToggleVariants['variant'];
            size?: ToggleVariants['size'];
        }
    >(),
    {
        variant: 'outline',
        size: 'default',
        disabled: false,
    },
);

const emits = defineEmits<ToggleEmits>();

const delegatedProps = reactiveOmit(props, 'class', 'size', 'variant');
const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <Toggle v-bind="forwarded" data-slot="toggle" :class="cn(toggleVariants({ variant, size }), props.class)">
        <slot />
    </Toggle>
</template>
