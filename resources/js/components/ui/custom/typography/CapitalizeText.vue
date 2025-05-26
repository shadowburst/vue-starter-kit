<script setup lang="ts">
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { Primitive, PrimitiveProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';

type Props = PrimitiveProps & {
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    as: 'span',
});
const delegatedProps = reactiveOmit(props, 'class', 'as');
</script>

<template>
    <Primitive v-bind="delegatedProps" :class="cn('inline-block first-letter:uppercase', props.class)" :as>
        <slot />
    </Primitive>
</template>
