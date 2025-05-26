<script setup lang="ts">
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import type { PrimitiveProps } from 'reka-ui';
import { Primitive } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import { type BadgeVariants, badgeVariants } from '.';

const props = defineProps<
    PrimitiveProps & {
        variant?: BadgeVariants['variant'];
        class?: HTMLAttributes['class'];
    }
>();

const delegatedProps = reactiveOmit(props, 'class');
</script>

<template>
    <Primitive v-bind="delegatedProps" data-slot="badge" :class="cn(badgeVariants({ variant }), props.class)">
        <slot />
    </Primitive>
</template>
