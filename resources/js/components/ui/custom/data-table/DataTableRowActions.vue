<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
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
            <Button
                variant="outline"
                size="sm"
                :class="cn('h-fit rounded-full px-2 py-1.5 font-semibold shadow-none', props.class)"
            >
                <EllipsisVerticalIcon class="h-3.5 w-3.5" />
                <CapitalizeText>
                    {{ $t('actions') }}
                </CapitalizeText>
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent align="end">
            <DropdownMenuGroup>
                <DataTableRowActionItem v-for="(action, index) in rowActions" :key="index" :action />
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
