<script setup lang="ts">
import { cn } from '@/lib/utils';
import { LucideIcon } from 'lucide-vue-next';
import { HTMLAttributes } from 'vue';

type Props = {
    as?: LucideIcon;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <component :is="as" :class="cn('absolute start-0 mx-4 my-auto size-5', props.class)" />
</template>
