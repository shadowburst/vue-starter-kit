<script setup lang="ts" generic="TData">
import { ButtonGroup } from '@/components/ui/button-group';
import { Checkbox } from '@/components/ui/checkbox';
import { ActionMenu } from '@/components/ui/custom/action-menu';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';

const { table, selectedActions } = injectDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => table.value.getIsAllPageRowsSelected() || (table.value.getIsSomeRowsSelected() && 'indeterminate'),
    set: (value) => table.value.toggleAllPageRowsSelected(value === true),
});

const selectedRows = computed(() => table.value.getSelectedRowModel().rows.map((row) => row.original));
</script>

<template>
    <ButtonGroup>
        <Checkbox v-model="checked" class="my-auto" />
        <ActionMenu
            v-if="table.getRowCount() > 0 && selectedActions.length"
            :actions="selectedActions"
            :payload="selectedRows"
        />
    </ButtonGroup>
</template>
