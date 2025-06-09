<script setup lang="ts" generic="TData">
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { computed } from 'vue';
import { injectDataTableRowContext } from './DataTableRow.vue';
import { DataTableRowAction } from './interface';

type Props = {
    action: DataTableRowAction<TData>;
};
const props = defineProps<Props>();

const { item } = injectDataTableRowContext<TData>();

const disabled = computed((): boolean => {
    const { action } = props;
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(item.value);
});

const hidden = computed((): boolean => {
    const { action } = props;
    if (!action.hidden) {
        return false;
    }
    if (typeof action.hidden === 'boolean') {
        return action.hidden;
    }
    return action.hidden(item.value);
});

const href = computed((): string | undefined => {
    const { action } = props;
    if (action.type !== 'href' || !action.href) {
        return;
    }
    if (typeof action.href === 'string') {
        return action.href;
    }
    return action.href(item.value);
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
        <DropdownMenuItem v-else-if="action.type === 'callback'" :disabled @click="action.callback(item)">
            <component :is="action.icon" />
            <CapitalizeText>
                {{ action.label }}
            </CapitalizeText>
        </DropdownMenuItem>
    </template>
</template>
