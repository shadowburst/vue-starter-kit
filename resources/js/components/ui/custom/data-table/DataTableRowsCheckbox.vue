<script setup lang="ts" generic="TData">
import { Checkbox } from '@/components/ui/checkbox';
import { CheckboxCheckedState } from 'reka-ui';
import { computed } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';

const { isAllRowsSelected, isSomeRowsSelected, toggleAllRowsSelected } = injectDataTableRootContext<TData>();

const checked = computed<CheckboxCheckedState>({
    get: () => isAllRowsSelected.value || (isSomeRowsSelected.value && 'indeterminate'),
    set: (value) => toggleAllRowsSelected(!!value),
});
</script>

<template>
    <Checkbox v-model="checked" aria-label="Select all" />
</template>
