<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Primitive } from 'reka-ui';
import { buttonVariants } from '.';
import { ButtonProps } from './interface';

const props = withDefaults(defineProps<ButtonProps>(), {
    as: 'button',
    type: 'button',
});
</script>

<template>
    <Primitive data-slot="button" :as :type :as-child :class="cn(buttonVariants({ variant, size }), props.class)">
        <slot />
    </Primitive>
</template>
