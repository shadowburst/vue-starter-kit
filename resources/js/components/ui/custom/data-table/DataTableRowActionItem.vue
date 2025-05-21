<script setup lang="ts" generic="TData">
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { injectDataTableRowContext } from './DataTableRow.vue';
import { DataTableRowAction, DataTableRowCallbackAction, DataTableRowHrefAction } from './interface';

type Props = {
    action: DataTableRowAction<TData>;
};
defineProps<Props>();

const { item } = injectDataTableRowContext<TData>();

function getHref(action: DataTableRowHrefAction<TData>): string | undefined {
    if (!action.href) {
        return;
    }

    return typeof action.href == 'string' ? action.href : action.href(item.value);
}

function getIsDisabled(action: DataTableRowCallbackAction<TData> | DataTableRowHrefAction<TData>): boolean {
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(item.value);
}
</script>

<template>
    <DropdownMenuItem v-if="action.type === 'href'" :disabled="getIsDisabled(action)" as-child>
        <InertiaLink :href="getHref(action)!">
            <component :is="action.icon" />
            <CapitalizeText>
                {{ action.label }}
            </CapitalizeText>
        </InertiaLink>
    </DropdownMenuItem>
    <DropdownMenuItem
        v-else-if="action.type === 'callback'"
        :disabled="getIsDisabled(action)"
        @click="action.callback(item)"
    >
        <component :is="action.icon" />
        <CapitalizeText>
            {{ action.label }}
        </CapitalizeText>
    </DropdownMenuItem>
    <component v-else-if="action.type === 'custom'" :is="action.component(item)" />
</template>
