<script lang="ts">
export type InertiaComboboxProps<T extends Record<string, any>> = Omit<ComboboxRootProps, 'modelValue' | 'by'> & {
    modelValue?: Arrayable<T>;
    data?: string | T[];
    label: Extract<keyof T, string>;
    by: Extract<keyof T, string>;
    multiplePlaceholder?: (items: T[]) => string;
    group?: boolean;
    groupBy?: Extract<keyof T, string> | ((item: T) => string);
    filter?: (item: T) => boolean;
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
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger,
} from '@/components/ui/combobox';
import { LoadingIcon } from '@/components/ui/custom/loading';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useArrayWrap, usePageProp } from '@/composables';
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

const delegatedProps = reactiveOmit(props, 'modelValue', 'label', 'data');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

const model = defineModel<Arrayable<T>>();
const modelArray = useArrayWrap<T>(model);
const models = computed<T[]>({
    get: () => modelArray.value,
    set: (value) => {
        if (props.multiple) {
            model.value = value;
            return;
        }
        if (!value.length) {
            model.value = undefined;
        } else {
            model.value = value[0];
        }
    },
});

const pageOptions = usePageProp<T[]>(() => (Array.isArray(props.data) ? undefined : props.data), []);
const options = computed((): T[] => {
    const list = Array.isArray(props.data) ? props.data : pageOptions.value;
    if (!model.value) {
        return list;
    }
    for (const value of models.value) {
        const index = list.findIndex((option) => option[props.by] === value[props.by]);
        if (index > -1) {
            list.splice(index, 1, value);
        } else {
            list.splice(0, 0, value);
        }
    }
    return list;
});

const { contains } = useFilter({ sensitivity: 'base' });
const searchTerm = ref<string>('');
const filteredOptions = computed((): T[] =>
    (props.filter ? options.value.filter(props.filter) : options.value).filter(({ [props.label]: label }) =>
        contains(label, searchTerm.value),
    ),
);

type Group = {
    label: string;
    options: T[];
};
const groups = computed((): Group[] => {
    if (!props.group || !props.groupBy) {
        return [
            {
                label: '',
                options: filteredOptions.value,
            },
        ];
    }

    return filteredOptions.value
        .reduce((groups, option) => {
            const groupLabel = typeof props.groupBy === 'string' ? props.groupBy : props.groupBy!(option);
            const groupIndex = groups.findIndex((group) => group.label === groupLabel);
            if (groupIndex > -1) {
                groups[groupIndex].options.push(option);
            } else {
                groups.push({
                    label: groupLabel,
                    options: [option],
                });
            }
            return groups;
        }, [] as Group[])
        .sort((a, b) => a.label.toLowerCase().localeCompare(b.label.toLowerCase()));
});

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
        <ComboboxTrigger as-child>
            <ComboboxAnchor class="relative w-full min-w-0 items-center">
                <ComboboxInput
                    v-model="searchTerm"
                    v-bind="$attrs"
                    :placeholder
                    :class="cn(models.length && !required ? 'pr-16' : 'pr-8', props.class)"
                />
                <div class="absolute inset-y-px end-px flex items-stretch" v-if="!disabled">
                    <Button
                        class="h-full rounded-none"
                        v-if="modelArray.length && !required"
                        size="icon"
                        variant="ghost"
                        @click.stop="models = []"
                    >
                        <XIcon />
                    </Button>
                    <Button class="h-full rounded-l-none" size="icon" variant="ghost">
                        <ChevronDownIcon />
                    </Button>
                </div>
            </ComboboxAnchor>
        </ComboboxTrigger>
        <ComboboxList>
            <WhenVisible v-if="!Array.isArray(data) && !pageOptions.length" :data>
                <template #fallback>
                    <div class="grid place-items-center py-2">
                        <LoadingIcon variant="primary" />
                    </div>
                </template>
                <ComboboxEmpty>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.combobox.empty') }}
                    </CapitalizeText>
                </ComboboxEmpty>
            </WhenVisible>
            <template v-else>
                <ComboboxGroup
                    v-for="group in groups"
                    :key="group.label"
                    :heading="groups.length > 1 ? group.label : undefined"
                >
                    <ComboboxVirtualizer
                        v-slot="{ option, virtualizer }"
                        :options="group.options"
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
                </ComboboxGroup>
                <ComboboxEmpty>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.combobox.empty') }}
                    </CapitalizeText>
                </ComboboxEmpty>
            </template>
        </ComboboxList>
    </Combobox>
</template>
