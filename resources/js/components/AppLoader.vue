<script setup lang="ts">
import { cn } from '@/lib/utils';
import { LoaderCircleIcon } from 'lucide-vue-next';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <LoaderCircleIcon :class="cn('text-primary size-8 animate-spin', props.class)" />
</template>
