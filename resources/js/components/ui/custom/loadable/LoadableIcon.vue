<script setup lang="ts">
import { refDebounced } from '@vueuse/core';
import { LucideIcon } from 'lucide-vue-next';
import { computed } from 'vue';
import LoadingIcon from './LoadingIcon.vue';

type Props = {
    icon?: LucideIcon;
    loading?: boolean;
};
const props = defineProps<Props>();
const loading = computed(() => props.loading ?? false);
const debouncedLoading = refDebounced(loading, 250);
</script>

<template>
    <LoadingIcon v-if="debouncedLoading" />
    <component v-else-if="icon" :is="icon" />
</template>
