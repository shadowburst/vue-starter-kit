<script setup lang="ts" generic="TData extends object">
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { ChevronDownIcon } from 'lucide-vue-next';
import { computed } from 'vue';
import { useDataTableRootContext } from './DataTable.vue';
import { DataTableMassAction } from './interface';

const rootContext = useDataTableRootContext<TData>();

const anySelected = computed((): boolean => rootContext.getIsAllRowsSelected() || rootContext.getIsSomeRowsSelected());

function getIsDisabled(action: DataTableMassAction<TData>): boolean {
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(rootContext.getSelectedRows());
}
</script>

<template>
    <DropdownMenu v-if="anySelected && rootContext.massActions.length">
        <DropdownMenuTrigger as-child>
            <Button variant="outline">
                <Capitalize>
                    {{ $t('actions') }}
                </Capitalize>
                <ChevronDownIcon />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="start">
            <DropdownMenuItem
                v-for="action in rootContext.massActions"
                :key="action.label"
                :disabled="getIsDisabled(action)"
                @click="action.callback(rootContext.getSelectedRows())"
            >
                <component :is="action.icon" />
                <Capitalize>
                    {{ action.label }}
                </Capitalize>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
