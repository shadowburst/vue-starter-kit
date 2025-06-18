<script setup lang="ts" generic="T extends { deleted_at?: string }">
import { Badge } from '@/components/ui/badge';
import { useFormatter } from '@/composables';
type Props = {
    item: T;
};
defineProps<Props>();

const format = useFormatter();
</script>

<template>
    <Badge v-if="item.deleted_at" variant="destructive">
        {{ format.date(item.deleted_at) }}
    </Badge>
</template>
