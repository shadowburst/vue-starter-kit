<script setup lang="ts" generic="TData">
import { Checkbox } from '@/components/ui/checkbox';
import { CellContext } from '@tanstack/vue-table';
import { computed } from 'vue';

type Props = CellContext<any, unknown>;
const { row } = defineProps<Props>();

const checked = computed<boolean>({
    get: () => row.getIsSelected(),
    set: (value) => row.toggleSelected(value),
});
</script>

<template>
    <Checkbox v-model="checked" aria-label="Select row" />
</template>
