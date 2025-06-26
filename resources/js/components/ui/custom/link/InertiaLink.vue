<script lang="ts">
export type LinkProps = InertiaLinkProps & {
    href?: string;
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
</script>

<script setup lang="ts">
import { InertiaLinkProps, Link } from '@inertiajs/vue3';
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';
import { computed, HTMLAttributes } from 'vue';

const props = withDefaults(defineProps<LinkProps>(), {
    prefetch: true,
});
const delegatedProps = reactiveOmit(props, 'as', 'disabled', 'href');
const forwarded = useForwardProps(delegatedProps);

const disabled = computed((): LinkProps['disabled'] => props.disabled || undefined);
const as = computed((): LinkProps['as'] => (props.disabled ? 'button' : props.as));
const href = computed((): LinkProps['href'] => (props.disabled || !props.href ? '#' : props.href));
const prefetch = computed((): LinkProps['prefetch'] => props.prefetch && (!props.method || props.method === 'get'));
</script>

<template>
    <Link v-bind="forwarded" :disabled :as :href :prefetch>
        <slot />
    </Link>
</template>
