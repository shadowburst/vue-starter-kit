<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { ChevronDownIcon } from 'lucide-vue-next';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';
import { DataTableRowsAction } from './interface';

const { rows, selectedRows, isAllRowsSelected, isSomeRowsSelected, rowsActions, toggleAllRowsSelected } =
    injectDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => isAllRowsSelected.value || (isSomeRowsSelected.value && 'indeterminate'),
    set: (value) => toggleAllRowsSelected(!!value),
});

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
    <DropdownMenu v-if="rows.length && rowsActions.length">
        <Button class="items-stretch gap-0 px-2" role="actions" size="sm" variant="ghost">
            <Checkbox class="my-auto" v-model="checked" aria-label="Select all" />
            <DropdownMenuTrigger class="pl-1" :class="{ invisible: !checked }">
                <ChevronDownIcon />
            </DropdownMenuTrigger>
        </Button>
        <DropdownMenuContent>
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
