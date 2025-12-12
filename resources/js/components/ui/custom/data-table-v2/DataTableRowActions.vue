<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { ActionMenu, ActionMenuDropdownTrigger } from '@/components/ui/custom/action-menu';
import { EllipsisVerticalIcon } from 'lucide-vue-next';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';
import { injectDataTableRowContext } from './DataTableRow.vue';

const { getActions } = injectDataTableRootContext<TData>();
const { row } = injectDataTableRowContext<TData>();

const actions = computed(() => (!row.value ? [] : getActions([row.value.original])));
</script>

<template>
    <ActionMenu v-if="actions.length && row" :actions :buttons="2">
        <ActionMenuDropdownTrigger role="actions" as-child>
            <Button variant="ghost" size="sm">
                <EllipsisVerticalIcon />
            </Button>
        </ActionMenuDropdownTrigger>
    </ActionMenu>
</template>
