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

<template>
    <form :class="cn('grid gap-4')" @submit.prevent="$emit('submit')">
        <slot />
    </form>
</template>
