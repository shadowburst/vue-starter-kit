<script setup lang="ts" generic="TData extends object">
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { InertiaLink } from '@/components/ui/link';
import { EllipsisVerticalIcon } from 'lucide-vue-next';
import { useDataTableRootContext } from './DataTable.vue';
import { useDataTableRowContext } from './DataTableRow.vue';
import { DataTableRowAction } from './interface';

const { rowActions } = useDataTableRootContext<TData>();
const { item } = useDataTableRowContext<TData>();

function getIsDisabled(action: DataTableRowAction<TData>): boolean {
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
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button class="h-fit rounded-full px-2 py-1.5 font-semibold shadow-none" variant="outline" size="sm">
                <EllipsisVerticalIcon class="h-3.5 w-3.5" />
                <Capitalize>
                    {{ $t('actions') }}
                </Capitalize>
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent align="end">
            <DropdownMenuGroup>
                <template v-for="(action, index) in rowActions" :key="index">
                    <DropdownMenuItem v-if="action.href" :disabled="getIsDisabled(action)" as-child>
                        <InertiaLink :href="action.href">
                            <component :is="action.icon" />
                            <Capitalize>
                                {{ action.label }}
                            </Capitalize>
                        </InertiaLink>
                    </DropdownMenuItem>
                    <DropdownMenuItem v-else :disabled="getIsDisabled(action)" @click="action.callback?.(item)">
                        <component :is="action.icon" />
                        <Capitalize>
                            {{ action.label }}
                        </Capitalize>
                    </DropdownMenuItem>
                </template>
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
