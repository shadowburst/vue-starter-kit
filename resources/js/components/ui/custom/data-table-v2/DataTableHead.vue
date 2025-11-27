<script setup lang="ts" generic="TData">
import { TableHead } from '@/components/ui/table';
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <TableHead
        :class="
            cn(
                'bg-background text-xs uppercase [&:has([role=actions])]:text-end [&:has([role=checkbox])]:w-1 [&:has([role=checkbox])]:pl-0',
                props.class,
            )
        "
    >
        <slot />
    </TableHead>
</template>
