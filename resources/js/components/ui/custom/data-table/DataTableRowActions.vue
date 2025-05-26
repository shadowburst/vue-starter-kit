<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { cn } from '@/lib/utils';
import { EllipsisVerticalIcon } from 'lucide-vue-next';
import { HTMLAttributes } from 'vue';
import { injectDataTableRootContext } from './DataTable.vue';
import DataTableRowActionItem from './DataTableRowActionItem.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { rowActions } = injectDataTableRootContext<TData>();
</script>

<template>
    <DropdownMenu v-if="rowActions.length">
        <DropdownMenuTrigger as-child>
            <Button role="actions" variant="ghost" size="icon" :class="cn('', props.class)">
                <EllipsisVerticalIcon />
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent align="end">
            <DropdownMenuGroup>
                <DataTableRowActionItem v-for="(action, index) in rowActions" :key="index" :action />
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
