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
import { HeaderContext } from '@tanstack/vue-table';
import { ChevronDownIcon } from 'lucide-vue-next';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';
import { DataTableMultiAction } from './interface';

defineProps<HeaderContext<any, unknown>>();

const { table, multiActions } = injectDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => table.value.getIsAllPageRowsSelected() || (table.value.getIsSomeRowsSelected() && 'indeterminate'),
    set: (value) => table.value.toggleAllPageRowsSelected(value === true),
});

const selectedRows = computed(() => table.value.getSelectedRowModel().rows.map((row) => row.original));
function getIsDisabled(action: DataTableMultiAction<TData>): boolean {
    if (action.type !== 'multi') {
        return false;
    }
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(selectedRows.value);
}
function getIsHidden(action: DataTableMultiAction<TData>): boolean {
    if (action.type !== 'multi') {
        return false;
    }
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
    <DropdownMenu v-if="table.getRowCount() > 0 && multiActions.length">
        <Button class="items-stretch gap-0 px-2" role="actions" size="sm" variant="ghost">
            <Checkbox v-model="checked" class="my-auto" />
            <DropdownMenuTrigger class="pl-1" :class="{ invisible: !checked }">
                <ChevronDownIcon />
            </DropdownMenuTrigger>
        </Button>
        <DropdownMenuContent>
            <DropdownMenuItem
                v-for="action in multiActions.filter((action) => !getIsHidden(action))"
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
