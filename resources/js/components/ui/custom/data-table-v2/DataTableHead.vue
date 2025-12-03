<script setup lang="ts" generic="TData">
import { TableHead } from '@/components/ui/table';
import { cn } from '@/lib/utils';
import { Header } from '@tanstack/vue-table';
import { computed, HTMLAttributes } from 'vue';

type Props = {
    header?: Header<TData, unknown>;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const style = computed((): HTMLAttributes['style'] => {
    const column = props.header?.column;
    if (!column) {
        return {};
    }

    const columnStyle: HTMLAttributes['style'] = {};
    const isPinned = column.getIsPinned();
    if (isPinned) {
        columnStyle.left = isPinned === 'left' ? `${column.getStart('left')}px` : undefined;
        columnStyle.right = isPinned === 'right' ? `${column.getAfter('right')}px` : undefined;
        columnStyle.position = 'sticky';
        columnStyle.width = column.getSize();
        columnStyle.zIndex = 1;

        if (isPinned === 'left' && column.getIsLastColumn('left')) {
            columnStyle.boxShadow = '-1px 0 0 0 var(--border) inset';
        }
        if (isPinned === 'right' && column.getIsFirstColumn('right')) {
            columnStyle.boxShadow = '1px 0 0 0 var(--border) inset';
        }
    }

    return columnStyle;
});
</script>

<template>
    <TableHead
        :class="
            cn(
                'bg-background text-xs uppercase [&:has([role=actions])]:text-end [&:has([role=checkbox])]:w-1 [&:has([role=checkbox])]:pl-0',
                props.class,
            )
        "
        :style
    >
        <slot />
    </TableHead>
</template>
