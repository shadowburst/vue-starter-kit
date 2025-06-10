<script setup lang="ts" generic="T extends string">
import { useArrayWrap, usePageProp } from '@/composables';
import { Enum } from '@/types';
import { WhenVisible } from '@inertiajs/vue3';
import { Arrayable } from '@vueuse/core';
import { transChoice } from 'laravel-vue-i18n';
import { useForwardPropsEmits } from 'reka-ui';
import { computed } from 'vue';
import InertiaCombobox, { InertiaComboboxEmits, InertiaComboboxProps } from './InertiaCombobox.vue';

defineOptions({
    inheritAttrs: false,
});

type TEnum = Enum<T>;

type Props = Omit<Partial<InertiaComboboxProps<TEnum>>, 'modelValue'>;
const props = withDefaults(defineProps<Props>(), {
    multiplePlaceholder: (items: TEnum[]) => transChoice('components.ui.custom.combobox.selected', items.length),
    by: 'value',
    label: 'label',
});

type Emits = InertiaComboboxEmits<TEnum>;
const emits = defineEmits<Emits>();

const forwarded = useForwardPropsEmits(props, emits);

const pageOptions = usePageProp<TEnum[]>(() => (Array.isArray(props.data) ? undefined : props.data), []);
const data = computed((): TEnum[] => (Array.isArray(props.data) ? props.data : pageOptions.value));

const model = defineModel<Arrayable<T>>();
const models = useArrayWrap<T>(model);
const proxy = computed<Arrayable<TEnum> | undefined>({
    get: () => {
        const values = data.value?.filter(({ value }) => models.value.includes(value)) ?? [];
        if (props.multiple) {
            return values;
        }
        if (!values.length) {
            return undefined;
        }
        return values[0];
    },
    set: (value) => {
        if (Array.isArray(value)) {
            model.value = value.map(({ value }) => value);
        } else {
            model.value = value?.value;
        }
    },
});
</script>

<template>
    <WhenVisible v-if="!Array.isArray(props.data) && !pageOptions.length" :data="props.data">
        <InertiaCombobox v-bind="{ ...forwarded, ...$attrs }" v-model="proxy" />
    </WhenVisible>
    <InertiaCombobox v-else v-bind="{ ...forwarded, ...$attrs }" v-model="proxy" />
</template>
