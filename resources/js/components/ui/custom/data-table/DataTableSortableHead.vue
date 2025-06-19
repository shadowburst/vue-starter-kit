<script setup lang="ts" generic="T">
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { ChevronDownIcon, ChevronsUpDownIcon, ChevronUpIcon } from 'lucide-vue-next';
import { computed, HTMLAttributes } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';
import DataTableHead from './DataTableHead.vue';

type Props = {
    value: string;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { sortBy, sortDirection } = injectDataTableRootContext();

const active = computed((): boolean => sortBy.value === props.value);

function sort() {
    if (active.value) {
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc';
        } else if (sortDirection.value === 'desc') {
            sortBy.value = undefined;
            sortDirection.value = undefined;
        }
    } else {
        sortBy.value = props.value;
        sortDirection.value = 'asc';
    }
}
</script>

<template>
    <DataTableHead :class="cn('px-0', props.class)">
        <Button class="w-full justify-between text-xs uppercase" size="sm" variant="ghost" @click="sort()">
            <slot />
            <ChevronsUpDownIcon v-if="!active" />
            <ChevronDownIcon v-else-if="sortDirection === 'desc'" />
            <ChevronUpIcon v-else-if="sortDirection === 'asc'" />
        </Button>
    </DataTableHead>
</template>
