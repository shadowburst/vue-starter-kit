<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { ActionMenu, ActionMenuDropdownTrigger } from '@/components/ui/custom/action-menu';
import { ChevronDownIcon } from 'lucide-vue-next';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';

const { table, getActions } = injectDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => table.value.getIsAllPageRowsSelected() || (table.value.getIsSomeRowsSelected() && 'indeterminate'),
    set: (value) => table.value.toggleAllPageRowsSelected(value === true),
});

const selectedRows = computed(() => table.value.getSelectedRowModel().rows.map((row) => row.original));
const actions = computed(() => getActions(selectedRows.value));
</script>

<template>
    <ActionMenu v-if="table.getRowCount() > 0 && actions.length" :actions>
        <ActionMenuDropdownTrigger as-child>
            <Button variant="ghost" size="sm" class="px-2">
                <Checkbox v-model="checked" class="my-auto" @click.stop.prevent />
                <ChevronDownIcon />
            </Button>
        </ActionMenuDropdownTrigger>
    </ActionMenu>
</template>
