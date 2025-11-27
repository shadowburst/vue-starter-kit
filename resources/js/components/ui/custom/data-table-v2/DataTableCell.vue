<script setup lang="ts">
import { injectDataTableRowContext } from '@/components/ui/custom/data-table-v2/DataTableRow.vue';
import { TableCell } from '@/components/ui/table';
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { row } = injectDataTableRowContext();
</script>

<template>
    <TableCell
        :class="
            cn(
                'group-hover/data-table-row:bg-muted/50 bg-background [&:has([role=actions])]:text-end',
                row?.getIsSelected() ? 'bg-muted' : '',
                props.class,
            )
        "
    >
        <slot />
    </TableCell>
</template>
