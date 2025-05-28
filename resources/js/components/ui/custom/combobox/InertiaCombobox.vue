<script lang="ts">
export type InertiaComboboxProps<T extends Record<string, any>> = Omit<ComboboxRootProps, 'modelValue' | 'by'> & {
    modelValue?: Arrayable<T>;
    data?: T[];
    label: Extract<keyof T, string>;
    by: Extract<keyof T, string>;
    multiplePlaceholder?: (items: T[]) => string;
    class?: HTMLAttributes['class'];
};
export type InertiaComboboxEmits<T extends Record<string, any>> = ComboboxRootEmits<T>;
</script>

<script setup lang="ts" generic="T extends Record<string, any>">
import { Button } from '@/components/ui/button';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger,
} from '@/components/ui/combobox';
import { LoadingIcon } from '@/components/ui/custom/loading';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { array } from '@/lib';
import { cn } from '@/lib/utils';
import { WhenVisible } from '@inertiajs/vue3';
import { Arrayable, reactiveOmit } from '@vueuse/core';
import { transChoice } from 'laravel-vue-i18n';
import { ChevronDownIcon, XIcon } from 'lucide-vue-next';
import { ComboboxRootEmits, ComboboxRootProps, ComboboxVirtualizer, useFilter, useForwardPropsEmits } from 'reka-ui';
import { computed, HTMLAttributes, ref } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = InertiaComboboxProps<T>;
const props = withDefaults(defineProps<Props>(), {
    multiplePlaceholder: (items: T[]) => transChoice('components.ui.custom.combobox.selected', items.length),
    ignoreFilter: () => true,
});
type Emits = InertiaComboboxEmits<T>;
const emits = defineEmits<Emits>();

const delegatedProps = reactiveOmit(props, 'modelValue', 'label', 'data', 'multiplePlaceholder');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

const model = defineModel<Arrayable<T>>();
const modelArray = computed((): T[] => array.wrap(model.value).filter((value) => value) as T[]);
const options = computed((): T[] => {
    const data = props.data ?? [];
    if (!model.value) {
        return data;
    }
    for (const value of modelArray.value) {
        const index = data.findIndex((option) => option[props.by] === value[props.by]);
        if (index > -1) {
            data.splice(index, 1, value);
        } else {
            data.splice(0, 0, value);
        }
    }
    return data;
});

const { contains } = useFilter({ sensitivity: 'base' });
const searchTerm = ref<string>('');
const filteredOptions = computed(() =>
    options.value.filter(({ [props.label]: label }) => contains(label, searchTerm.value)),
);

const placeholder = computed(() => {
    if (!model.value) {
        return;
    }
    if (!modelArray.value.length) {
        return;
    }
    if (!props.multiple) {
        return modelArray.value[0][props.label];
    }

    return props.multiplePlaceholder(modelArray.value);
});
</script>

<template>
    <Combobox v-model="model" v-bind="forwarded">
        <ComboboxAnchor as-child>
            <div class="relative w-full items-center">
                <ComboboxInput
                    v-model="searchTerm"
                    v-bind="$attrs"
                    :placeholder
                    :class="cn(modelArray.length && !required ? 'pr-16' : 'pr-8', props.class)"
                />
                <div class="absolute inset-y-0 end-0 flex items-center pe-px">
                    <Button
                        class="size-8"
                        v-if="modelArray.length && !required"
                        size="icon"
                        variant="ghost"
                        @click="model = multiple ? [] : undefined"
                    >
                        <XIcon />
                    </Button>
                    <ComboboxTrigger as-child>
                        <Button class="size-8" size="icon" variant="ghost">
                            <ChevronDownIcon />
                        </Button>
                    </ComboboxTrigger>
                </div>
            </div>
        </ComboboxAnchor>
        <ComboboxList>
            <WhenVisible v-if="!Array.isArray(data) && !pageOptions.length" :data>
                <template #fallback>
                    <div class="grid place-items-center py-2">
                        <LoadingIcon variant="primary" />
                    </div>
                </template>
            </WhenVisible>
            <template v-else>
                <ComboboxVirtualizer
                    v-slot="{ option, virtualizer }"
                    :options="filteredOptions"
                    :text-content="(option) => option[label]"
                >
                    <div class="w-full" :ref="(node) => virtualizer.measureElement(node as Element)">
                        <ComboboxItem :value="option" :text-value="option[label]">
                            <ComboboxItemIndicator />
                            <CapitalizeText class="min-w-0 grow break-words">
                                {{ option[label] }}
                            </CapitalizeText>
                        </ComboboxItem>
                    </div>
                </ComboboxVirtualizer>
                <ComboboxEmpty>
                    {{ $t('components.ui.custom.combobox.empty') }}
                </ComboboxEmpty>
            </template>
        </ComboboxList>
    </Combobox>
</template>
