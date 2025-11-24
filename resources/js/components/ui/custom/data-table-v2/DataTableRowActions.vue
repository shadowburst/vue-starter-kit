<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { EllipsisVerticalIcon } from 'lucide-vue-next';
import { injectDataTableRootContext } from './DataTable.vue';
import { injectDataTableRowContext } from './DataTableRow.vue';
import DataTableRowActionsItem from './DataTableRowActionsItem.vue';

const { rowActions } = injectDataTableRootContext<TData>();
const { row } = injectDataTableRowContext<TData>();
</script>

<template>
    <DropdownMenu v-if="rowActions.length && row">
        <DropdownMenuTrigger as-child>
            <Button role="actions" variant="ghost" size="icon">
                <EllipsisVerticalIcon />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuGroup>
                <DataTableRowActionsItem v-for="(action, index) in rowActions" :key="index" :action :row />
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
