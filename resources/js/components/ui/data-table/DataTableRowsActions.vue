<script setup lang="ts" generic="TData extends object">
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { ChevronDownIcon } from 'lucide-vue-next';
import { useDataTableRootContext } from './DataTable.vue';
import { DataTableRowsAction } from './interface';

const { selectedRows, isAnyRowsSelected, rowsActions } = useDataTableRootContext<TData>();

function getIsDisabled(action: DataTableRowsAction<TData>): boolean {
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(selectedRows.value);
}
</script>

<template>
    <DropdownMenu v-if="rowsActions.length">
        <DropdownMenuTrigger as-child>
            <Button variant="outline" :class="{ 'opacity-0': !isAnyRowsSelected }">
                <Capitalize>
                    {{ $t('actions') }}
                </Capitalize>
                <ChevronDownIcon />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="start">
            <DropdownMenuItem
                v-for="action in rowsActions"
                :key="action.label"
                :disabled="getIsDisabled(action)"
                @click="action.callback(selectedRows)"
            >
                <component :is="action.icon" />
                <Capitalize>
                    {{ action.label }}
                </Capitalize>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
