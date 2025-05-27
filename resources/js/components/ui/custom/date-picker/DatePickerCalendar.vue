<script setup lang="ts">
import {
    CalendarCell,
    CalendarCellTrigger,
    CalendarGrid,
    CalendarGridBody,
    CalendarGridHead,
    CalendarGridRow,
    CalendarHeadCell,
    CalendarHeader,
    CalendarHeading,
    CalendarNextButton,
    CalendarPrevButton,
} from '@/components/ui/calendar';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { CalendarRoot, type CalendarRootEmits, type CalendarRootProps, useForwardPropsEmits } from 'reka-ui';
import { type HTMLAttributes } from 'vue';

type Props = CalendarRootProps & {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const emits = defineEmits<CalendarRootEmits>();

const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <CalendarRoot v-slot="{ grid, weekDays }" v-bind="forwarded" :class="cn('p-3', props.class)">
        <CalendarHeader>
            <CalendarPrevButton />
            <CalendarHeading />
            <CalendarNextButton />
        </CalendarHeader>

        <div class="mt-4 flex flex-col gap-y-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
            <CalendarGrid v-for="month in grid" :key="month.value.toString()">
                <CalendarGridHead>
                    <CalendarGridRow>
                        <CalendarHeadCell v-for="day in weekDays" :key="day">
                            {{ day }}
                        </CalendarHeadCell>
                    </CalendarGridRow>
                </CalendarGridHead>
                <CalendarGridBody>
                    <CalendarGridRow
                        class="mt-2 w-full"
                        v-for="(weekDates, index) in month.rows"
                        :key="`weekDate-${index}`"
                    >
                        <CalendarCell v-for="weekDate in weekDates" :key="weekDate.toString()" :date="weekDate">
                            <CalendarCellTrigger :day="weekDate" :month="month.value" />
                        </CalendarCell>
                    </CalendarGridRow>
                </CalendarGridBody>
            </CalendarGrid>
        </div>
    </CalendarRoot>
</template>
