<script setup lang="ts" generic="TData">
import { Checkbox } from '@/components/ui/checkbox';
import { injectDataTableRowContext } from '@/components/ui/custom/data-table-v2/DataTableRow.vue';
import { computed } from 'vue';

const { row } = injectDataTableRowContext<TData>();

const checked = computed<boolean>({
    get: () => row.value?.getIsSelected() ?? false,
    set: (value) => row.value?.toggleSelected(value),
});
</script>

<template>
    <Checkbox v-model="checked" aria-label="Select row" />
</template>
