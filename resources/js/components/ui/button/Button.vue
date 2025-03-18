<template>
    <Primitive v-bind="props" :type :as :class="cn(buttonVariants({ variant, size }), props.class)">
        <slot />
    </Primitive>
</template>

<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Primitive } from 'reka-ui';
import { buttonVariants } from '.';
import { ButtonProps } from './interface';

const { as = 'button', type = 'button', ...props } = defineProps<ButtonProps>();
</script>
