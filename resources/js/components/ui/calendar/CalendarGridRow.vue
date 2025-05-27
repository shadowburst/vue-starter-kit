<script lang="ts" setup>
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { CalendarGridRow, type CalendarGridRowProps, useForwardProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

const props = defineProps<CalendarGridRowProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = reactiveOmit(props, 'class');

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <CalendarGridRow v-bind="forwardedProps" data-slot="calendar-grid-row" :class="cn('flex', props.class)">
        <slot />
    </CalendarGridRow>
</template>
