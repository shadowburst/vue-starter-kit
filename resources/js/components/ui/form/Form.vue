<template>
    <form :class="cn('grid gap-6')" @submit.prevent="$emit('submit')">
        <slot />
    </form>
</template>

<script setup lang="ts">
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
defineProps<Props>();

type Emits = {
    submit: [];
};
defineEmits<Emits>();
</script>
