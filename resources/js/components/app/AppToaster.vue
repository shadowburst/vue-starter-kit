<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import { router } from '@inertiajs/vue3';
import { useDark } from '@vueuse/core';
import { onUnmounted } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';

onUnmounted(
    router.on('flash', (event) => {
        const data = event.detail.flash.toast;
        if (data) {
            toast[data.type](data.message, {});
        }
    }),
);

const dark = useDark();
</script>

<template>
    <Toaster position="top-right" :theme="dark ? 'dark' : 'light'" />
</template>
