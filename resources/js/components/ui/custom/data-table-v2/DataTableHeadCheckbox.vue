<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Checkbox } from '@/components/ui/checkbox';
import { ActionMenuDropdown } from '@/components/ui/custom/action-menu';
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
    <ButtonGroup>
        <Checkbox v-model="checked" class="my-auto" />
        <ActionMenuDropdown v-if="table.getRowCount() > 0 && actions.length" :actions>
            <Button variant="ghost" size="icon-sm">
                <ChevronDownIcon />
            </Button>
        </ActionMenuDropdown>
    </ButtonGroup>
</template>
