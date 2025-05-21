<script setup lang="ts" generic="T extends string">
import { usePageProp } from '@/composables';
import { reactiveOmit } from '@vueuse/core';
import { transChoice } from 'laravel-vue-i18n';
import { useForwardPropsEmits } from 'reka-ui';
import { computed } from 'vue';
import InertiaCombobox, { InertiaComboboxEmits, InertiaComboboxProps } from './InertiaCombobox.vue';

type Props = Partial<InertiaComboboxProps<T>>;
const props = withDefaults(defineProps<Props>(), {
    multiplePlaceholder: (items: T[]) => transChoice('components.ui.selected', items.length),
});
type Emits = InertiaComboboxEmits<T>;
const emits = defineEmits<Emits>();

const pageOptions = usePageProp<T[]>(() => (Array.isArray(props.data) ? undefined : props.data), []);
const data = computed((): T[] => (Array.isArray(props.data) ? props.data : pageOptions.value));

const delegatedProps = reactiveOmit(props, 'data');
const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <InertiaCombobox v-bind="forwarded" :data />
</template>
