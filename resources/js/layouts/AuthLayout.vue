<script setup lang="ts">
import { useLayout } from '@/composables/useLayout';
import AuthLayout from '@/layouts/auth/AuthSplitLayout.vue';

const title = defineModel<string>('title');
const description = defineModel<string>('description');

useLayout((data: { title?: string; description?: string }) => {
    title.value = data.title;
    description.value = data.description;
});
</script>

<template>
    <AuthLayout :title :description>
        <slot />
    </AuthLayout>
</template>
