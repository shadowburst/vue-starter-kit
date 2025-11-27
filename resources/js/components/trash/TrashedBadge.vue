<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { useFormatter } from '@/composables';
import { computed } from 'vue';

type Props = {
    date: string | undefined;
};
const props = defineProps<Props>();

const format = useFormatter();
const date = computed(() => format.date(props.date));
</script>

<template>
    <Badge v-if="date" variant="destructive">
        {{ date }}
    </Badge>
</template>
