<script lang="ts">
type FiltersSheetRootContext<TForm extends FormDataType> = {
    filters: FiltersForm<TForm>;
    fields: Ref<(keyof TForm)[]>;
    count: Ref<number>;
};
export function injectFiltersSheetRootContext<TForm extends FormDataType>(
    fallback?: FiltersSheetRootContext<TForm>,
): FiltersSheetRootContext<TForm> {
    const context = inject('FiltersSheetRootContext', fallback);

    if (!context) {
        throw new Error(`Injection \`FiltersSheetRootContext\` not found. Component must be used within a \`Form\``);
    }

    return context;
}
export function provideFiltersSheetRootContext<TForm extends FormDataType>(
    contextValue: FiltersSheetRootContext<TForm>,
) {
    return provide('FiltersSheetRootContext', contextValue);
}
</script>

<script setup lang="ts" generic="TForm extends FormDataType">
import { Sheet } from '@/components/ui/sheet';
import { FiltersForm } from '@/composables';
import { FormDataType } from '@/types';
import { reactiveOmit } from '@vueuse/core';
import { type DialogRootEmits, type DialogRootProps, useForwardPropsEmits } from 'reka-ui';
import { computed, inject, provide, Ref } from 'vue';

type Props = DialogRootProps & {
    filters: FiltersForm<TForm>;
    omit?: (keyof TForm)[];
    pick?: (keyof TForm)[];
};
const props = withDefaults(defineProps<Props>(), {
    omit: () => [],
    pick: () => [],
});
const emits = defineEmits<DialogRootEmits>();
const delegatedProps = reactiveOmit(props, 'filters', 'omit', 'pick');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

const fields = computed((): (keyof TForm)[] =>
    Object.keys(props.filters.data()).filter((key) => props.pick.includes(key) || !props.omit.includes(key)),
);

const count = computed(() => Object.keys(props.filters.params).filter((key) => fields.value.includes(key)).length);

provideFiltersSheetRootContext({
    filters: props.filters,
    fields,
    count,
});
</script>

<template>
    <Sheet v-bind="forwarded">
        <slot />
    </Sheet>
</template>
