<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSplitLayout.vue';

type Props = {
    title: string;
    description: string;
};
defineProps<Props>();
</script>

<template>
    <AuthLayout :title :description>
        <slot />
    </AuthLayout>
</template>
