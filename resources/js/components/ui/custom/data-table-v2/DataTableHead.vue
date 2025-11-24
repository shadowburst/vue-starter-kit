<script setup lang="ts" generic="T">
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
                'text-xs uppercase [&:has([role=actions])]:pl-0 [&:has([role=actions])]:text-end [&:has([role=checkbox])]:w-1',
                props.class,
            )
        "
    >
        <slot />
    </TableHead>
</template>
