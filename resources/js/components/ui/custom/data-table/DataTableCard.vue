<script setup lang="ts" generic="TData">
import { Card } from '@/components/ui/card';
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';
import DataTableRow, { DataTableRowProps } from './DataTableRow.vue';

type Props = DataTableRowProps<TData>;
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'as');
const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <DataTableRow v-bind="forwarded" :as="as ?? Card">
        <slot />
    </DataTableRow>
</template>
