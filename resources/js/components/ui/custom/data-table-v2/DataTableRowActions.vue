<script setup lang="ts" generic="TData">
import { ActionMenu } from '@/components/ui/custom/action-menu';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';
import { injectDataTableRowContext } from './DataTableRow.vue';

const { getActions } = injectDataTableRootContext<TData>();
const { row } = injectDataTableRowContext<TData>();

const actions = computed(() => (!row.value ? [] : getActions([row.value.original])));
</script>

<template>
    <ActionMenu v-if="actions.length && row" :actions />
</template>
