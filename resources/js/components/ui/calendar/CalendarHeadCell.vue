<script lang="ts" setup>
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { CalendarHeadCell, type CalendarHeadCellProps, useForwardProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

const props = defineProps<CalendarHeadCellProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = reactiveOmit(props, 'class');

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <CalendarHeadCell
        v-bind="forwardedProps"
        data-slot="calendar-head-cell"
        :class="cn('text-muted-foreground w-8 rounded-md text-[0.8rem] font-normal', props.class)"
    >
        <slot />
    </CalendarHeadCell>
</template>
