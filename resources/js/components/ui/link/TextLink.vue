<script setup lang="ts">
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';
import InertiaLink, { LinkProps } from './InertiaLink.vue';

type Props = LinkProps;
const props = defineProps<Props>();

const delegatedProps = reactiveOmit(props, 'class');

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <InertiaLink
        v-bind="forwarded"
        :class="
            cn(
                'text-foreground decoration-muted-foreground ring-offset-background focus-visible:ring-ring rounded-sm underline underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-hidden enabled:cursor-pointer',
                props.class,
            )
        "
    >
        <slot />
    </InertiaLink>
</template>
