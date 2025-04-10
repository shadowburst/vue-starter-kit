<script setup lang="ts">
import { cn } from '@/lib/utils';
import { LoaderCircleIcon } from 'lucide-vue-next';
import { Primitive } from 'reka-ui';
import { buttonVariants } from '.';
import { ButtonProps } from './interface';

const { as = 'button', type = 'button', ...props } = defineProps<ButtonProps>();
</script>

<template>
    <Primitive
        data-slot="button"
        :as
        :type
        :as-child
        :disabled="disabled || loading"
        :class="cn(buttonVariants({ variant, size }), props.class)"
    >
        <LoaderCircleIcon class="animate-spin" v-if="loading" />
        <component v-else-if="icon" :is="icon" />
        <slot />
    </Primitive>
</template>
