<script setup lang="ts">
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { Primitive, PrimitiveProps, useForwardProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';

type Props = PrimitiveProps & {
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    as: 'div',
});
const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <Primitive v-bind="forwarded" :class="cn('flex w-full items-center justify-end gap-2', props.class)">
        <slot />
    </Primitive>
</template>
