<script setup lang="ts" generic="TData">
import { ActionMenu } from '@/components/ui/custom/action-menu';
import { injectDataTableRootContext } from './DataTable.vue';
import { injectDataTableRowContext } from './DataTableRow.vue';

const { rowActions } = injectDataTableRootContext<TData>();
const { row } = injectDataTableRowContext<TData>();
</script>

<template>
    <ActionMenu v-if="rowActions.length && row" :actions="rowActions" :payload="row.original" />
</template>
