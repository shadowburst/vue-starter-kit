<script lang="ts" setup>
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { CalendarHeading, type CalendarHeadingProps, useForwardProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

const props = defineProps<CalendarHeadingProps & { class?: HTMLAttributes['class'] }>();

defineSlots<{
    default: (props: { headingValue: string }) => any;
}>();

const delegatedProps = reactiveOmit(props, 'class');

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <CalendarHeading
        v-slot="{ headingValue }"
        v-bind="forwardedProps"
        data-slot="calendar-heading"
        :class="cn('text-sm font-medium', props.class)"
    >
        <slot :heading-value>
            {{ headingValue }}
        </slot>
    </CalendarHeading>
</template>
