<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
}

defineProps<Props>();
</script>

<template>
    <header>
        <h3 class="mb-0.5 text-base font-medium">{{ title }}</h3>
        <p class="text-sm text-muted-foreground" v-if="description">
            {{ description }}
        </p>
    </header>
</template>
