<script lang="ts" setup>
import { buttonVariants } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { ChevronRight } from 'lucide-vue-next';
import { CalendarNext, type CalendarNextProps, useForwardProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

const props = defineProps<CalendarNextProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = reactiveOmit(props, 'class');

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <CalendarNext
        v-bind="forwardedProps"
        data-slot="calendar-next-button"
        :class="
            cn(
                buttonVariants({ variant: 'outline' }),
                'absolute right-1',
                'size-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                props.class,
            )
        "
    >
        <slot>
            <ChevronRight class="size-4" />
        </slot>
    </CalendarNext>
</template>
