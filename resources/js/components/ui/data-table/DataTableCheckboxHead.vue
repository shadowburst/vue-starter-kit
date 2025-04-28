<script setup lang="ts" generic="TData extends object">
import { Checkbox } from '@/components/ui/checkbox';
import { TableHead } from '@/components/ui/table';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { useDataTableRootContext } from './DataTable.vue';

const { isAllRowsSelected, isSomeRowsSelected, toggleAllRowsSelected } = useDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => isAllRowsSelected.value || (isSomeRowsSelected.value && 'indeterminate'),
    set: (value) => toggleAllRowsSelected(!!value),
});
</script>

<template>
    <TableHead>
        <Checkbox v-model="checked" aria-label="Select all" />
    </TableHead>
</template>
