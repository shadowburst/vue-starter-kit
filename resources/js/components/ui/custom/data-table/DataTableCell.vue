<script setup lang="ts">
import { TableCell } from '@/components/ui/table';
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <TableCell :class="cn('[&:has([role=actions])]:text-end', props.class)">
        <slot />
    </TableCell>
</template>
