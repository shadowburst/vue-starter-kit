<script setup lang="ts">
import { CapitalizeText } from '@/components/ui/custom/typography';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { PrimitiveProps, useForwardProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

type Props = PrimitiveProps & {
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    as: () => 'h3',
});
const delegatedProps = reactiveOmit(props, 'class', 'as');
const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <CapitalizeText
        v-bind="forwarded"
        data-slot="section-title"
        :as
        :class="cn('text-xl leading-none font-semibold', props.class)"
    >
        <slot />
    </CapitalizeText>
</template>
