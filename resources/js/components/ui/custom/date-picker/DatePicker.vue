<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { useFormatter, useParser } from '@/composables';
import { type DateValue } from '@internationalized/date';
import { reactiveOmit } from '@vueuse/core';
import { CalendarIcon, XIcon } from 'lucide-vue-next';
import { DateFieldInput, DateFieldRoot, DateFieldRootProps, useForwardProps } from 'reka-ui';
import { computed, HTMLAttributes, ref } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = Omit<DateFieldRootProps, 'modelValue' | 'minValue' | 'maxValue'> & {
    modelValue?: string;
    maxValue?: DateValue | string;
    minValue?: DateValue | string;
    autofocus?: boolean;
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'modelValue', 'class', 'maxValue', 'minValue', 'autofocus', 'disabled');
const forwarded = useForwardProps(delegatedProps);

const open = ref<boolean>(false);

const parse = useParser();
const maxValue = computed(() => parse.toDate(props.maxValue));
const minValue = computed(() => parse.toDate(props.minValue));

const format = useFormatter();
const model = defineModel<string>();
const proxy = computed<DateValue | undefined>({
    get: () => (model.value ? parse.toDate(model.value) : undefined),
    set: (value?: DateValue) => {
        open.value = false;
        model.value = !value ? undefined : format.timestamp(value);
    },
});
</script>

<template>
    <Popover v-model:open="open">
        <div
            class="border-input flex h-9 w-full items-stretch gap-1 rounded-md border bg-transparent text-sm shadow-xs transition-colors select-all"
            :class="{ 'cursor-not-allowed opacity-50 select-none': disabled }"
        >
            <DateFieldRoot
                class="my-auto mr-auto flex pl-3"
                v-model="proxy"
                v-bind="{ ...forwarded, ...$attrs }"
                v-slot="{ segments }"
                :disabled
                :max-value
                :min-value
            >
                <template v-for="(item, index) in segments" :key="item.part">
                    <DateFieldInput
                        class="enabled:text-muted-foreground p-0.5"
                        v-if="item.part === 'literal'"
                        :part="item.part"
                    >
                        {{ item.value }}
                    </DateFieldInput>
                    <DateFieldInput
                        class="ring-ring data-[placeholder]:text-muted-foreground rounded p-0.5 transition-colors outline-none focus-within:ring-1"
                        v-else
                        :autofocus="autofocus && index === 0"
                        :part="item.part"
                    >
                        {{ item.value }}
                    </DateFieldInput>
                </template>
            </DateFieldRoot>
            <Button
                class="h-full rounded-none"
                v-if="model && !required && !disabled"
                size="icon"
                variant="ghost"
                @click="model = undefined"
            >
                <XIcon />
            </Button>
            <PopoverTrigger as-child>
                <Button class="h-full rounded-l-none" size="icon" variant="ghost" :disabled>
                    <CalendarIcon />
                </Button>
            </PopoverTrigger>
        </div>
        <PopoverContent class="w-auto p-0" align="end">
            <Calendar v-model="proxy" :max-value :min-value :locale />
        </PopoverContent>
    </Popover>
</template>
