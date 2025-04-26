<script setup lang="ts" generic="TData extends object">
import { Checkbox } from '@/components/ui/checkbox';
import { TableHead } from '@/components/ui/table';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { useDataTableRootContext } from './DataTable.vue';

const rootContext = useDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => rootContext.isAllRowsSelected.value || (rootContext.isSomeRowsSelected.value && 'indeterminate'),
    set: (value) => rootContext.toggleAllRowsSelected(!!value),
});
</script>

<template>
    <TableHead>
        <Checkbox v-model="checked" aria-label="Select all" />
    </TableHead>
</template>
