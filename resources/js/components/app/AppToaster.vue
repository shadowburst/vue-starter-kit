<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import { ToastMessagesData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { useDark } from '@vueuse/core';
import { computed, watch } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';

const data = computed((): ToastMessagesData => usePage().props.toast);
watch(
    data,
    () => {
        Object.keys(data.value)
            .filter((key) => data.value[key as keyof ToastMessagesData])
            .forEach((key, i) => {
                const type = key as keyof ToastMessagesData;
                const message = data.value[type];
                if (!message) {
                    return;
                }

                setTimeout(() => {
                    toast[type](message, {});
                }, 250 * i);
            });
    },
    { immediate: true },
);

const dark = useDark();
</script>

<template>
    <Toaster position="top-right" :theme="dark ? 'dark' : 'light'" />
</template>
