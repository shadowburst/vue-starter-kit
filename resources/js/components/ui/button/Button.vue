<script setup lang="ts">
import { cn } from '@/lib/utils';
import { LoaderCircleIcon } from 'lucide-vue-next';
import { Primitive } from 'reka-ui';
import { buttonVariants } from '.';
import { ButtonProps } from './interface';

const { as = 'button', type = 'button', loading, icon, ...props } = defineProps<ButtonProps>();
</script>

<template>
    <Primitive v-bind="props" :type :as :class="cn(buttonVariants({ variant, size }), props.class)">
        <LoaderCircleIcon class="size-5 animate-spin" v-if="loading" />
        <component class="size-5" v-else-if="icon" :is="icon" />
        <slot />
    </Primitive>
</template>
