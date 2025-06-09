<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { ChevronDownIcon } from 'lucide-vue-next';
import { injectDataTableRootContext } from './DataTable.vue';
import { DataTableRowsAction } from './interface';

const { selectedRows, isAnyRowsSelected, rowsActions } = injectDataTableRootContext<TData>();

function getIsDisabled(action: DataTableRowsAction<TData>): boolean {
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(selectedRows.value);
}
function getIsHidden(action: DataTableRowsAction<TData>): boolean {
    if (!action.hidden) {
        return false;
    }
    if (typeof action.hidden === 'boolean') {
        return action.hidden;
    }
    return action.hidden(selectedRows.value);
}
</script>

<template>
    <DropdownMenu v-if="rowsActions.length">
        <DropdownMenuTrigger as-child>
            <Button variant="outline" :disabled="!isAnyRowsSelected">
                <CapitalizeText>
                    {{ $t('actions') }}
                </CapitalizeText>
                <ChevronDownIcon />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="start">
            <DropdownMenuItem
                v-for="action in rowsActions.filter((action) => !getIsHidden(action))"
                :key="action.label"
                :disabled="getIsDisabled(action)"
                @click="action.callback(selectedRows)"
            >
                <component :is="action.icon" />
                <CapitalizeText>
                    {{ action.label }}
                </CapitalizeText>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
