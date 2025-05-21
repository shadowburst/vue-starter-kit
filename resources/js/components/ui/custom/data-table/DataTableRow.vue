<script lang="ts">
export type DataTableRowProps<TData> = PrimitiveProps & {
    item?: TData;
};
export type DataTableRowContext<TData> = {
    item: Ref<TData>;
    isSelected: Ref<boolean>;
    toggleSelected: (value: boolean) => void;
};

export function injectDataTableRowContext<TData>(fallback?: DataTableRowContext<TData>): DataTableRowContext<TData> {
    const context = inject('DataTableRowContext', fallback);

    if (!context) {
        throw new Error(`Injection \`DataTableRowContext\` not found. Component must be used within a \`DataTable\``);
    }

    return context;
}
export function provideDataTableRowContext<TData>(contextValue: DataTableRowContext<TData>) {
    return provide('DataTableRowContext', contextValue);
}
</script>

<script setup lang="ts" generic="TData">
import { TableRow } from '@/components/ui/table';
import { reactiveOmit } from '@vueuse/core';
import { Primitive, PrimitiveProps, useForwardProps } from 'reka-ui';
import { computed, inject, provide, Ref, toRefs } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';

type Props = DataTableRowProps<TData>;
const props = defineProps<Props>();
const { item } = toRefs(props);
const delegatedProps = reactiveOmit(props, 'item', 'as');
const forwarded = useForwardProps(delegatedProps);

const { getIsSelected, toggleSelected } = injectDataTableRootContext<TData>();
const rowContext: DataTableRowContext<TData> | undefined = item
    ? {
          item,
          isSelected: computed(() => getIsSelected(item.value)),
          toggleSelected: (value) => toggleSelected(item.value, value),
      }
    : undefined;
if (rowContext) {
    provideDataTableRowContext(rowContext);
}
</script>

<template>
    <Primitive
        v-bind="forwarded"
        :as="as ?? TableRow"
        :data-state="rowContext?.isSelected.value ? 'selected' : undefined"
    >
        <slot />
    </Primitive>
</template>
