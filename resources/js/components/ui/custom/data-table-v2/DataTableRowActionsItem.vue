<script setup lang="ts" generic="TData">
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Row } from '@tanstack/vue-table';
import { computed } from 'vue';
import { DataTableRowAction } from './interface';

type Props = {
    action: DataTableRowAction<TData>;
    row: Row<TData>;
};
const { action, row } = defineProps<Props>();

const disabled = computed((): boolean => {
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(row.original);
});

const hidden = computed((): boolean => {
    if (!action.hidden) {
        return false;
    }
    if (typeof action.hidden === 'boolean') {
        return action.hidden;
    }
    return action.hidden(row.original);
});

const href = computed((): string | undefined => {
    if (action.type !== 'href' || !action.href) {
        return;
    }
    if (typeof action.href === 'string') {
        return action.href;
    }
    return action.href(row.original);
});
</script>

<template>
    <template v-if="!hidden">
        <DropdownMenuItem v-if="action.type === 'href'" :disabled as-child>
            <InertiaLink :href="href!">
                <component :is="action.icon" />
                <CapitalizeText>
                    {{ action.label }}
                </CapitalizeText>
            </InertiaLink>
        </DropdownMenuItem>
        <DropdownMenuItem v-else-if="action.type === 'callback'" :disabled @click="action.callback(row.original)">
            <component :is="action.icon" />
            <CapitalizeText>
                {{ action.label }}
            </CapitalizeText>
        </DropdownMenuItem>
    </template>
</template>
