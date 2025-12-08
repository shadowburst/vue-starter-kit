<script lang="ts">
export type DateInputProps = Omit<CalendarRootProps, 'modelValue'> & {
    class?: HTMLAttributes['class'];
};
</script>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { useFormatter, useParser } from '@/composables';
import { CalendarDate } from '@internationalized/date';
import { reactiveOmit } from '@vueuse/core';
import { CalendarIcon } from 'lucide-vue-next';
import { CalendarRootProps, useForwardProps } from 'reka-ui';
import { computed, HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps<DateInputProps>();
const forwarded = useForwardProps(reactiveOmit(props, 'minValue', 'maxValue', 'class'));

const model = defineModel<number>();

const parse = useParser();
const format = useFormatter();

const proxy = computed<CalendarDate | undefined>({
    get: () => parse.toDate(model.value),
    set: (value) => {
        model.value = parse.toTimestamp(value);
    },
});
const label = computed(() => format.date(proxy.value));

const minValue = computed(() => parse.toDate(props.minValue));
const maxValue = computed(() => parse.toDate(props.maxValue));
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button>
                <CalendarIcon />
                {{ label }}
            </Button>
        </PopoverTrigger>
        <PopoverContent>
            <Calendar v-bind="forwarded" v-model="proxy" :min-value :max-value />
        </PopoverContent>
    </Popover>
</template>
