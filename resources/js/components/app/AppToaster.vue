<script setup lang="ts">
import { toast, Toaster, ToastVariants } from '@/components/ui/toast';
import { SharedData, ToastMessagesData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { computed, watch } from 'vue';

type ToastType = keyof ToastMessagesData;

const titles: Record<ToastType, string> = {
    info: trans('info'),
    success: trans('success'),
    warning: trans('warning'),
    error: trans('error'),
};

const variants: Record<ToastType, ToastVariants['variant']> = {
    info: 'default',
    success: 'primary',
    warning: 'warning',
    error: 'destructive',
};

const data = computed((): ToastMessagesData => usePage<SharedData>().props.toast);
watch(
    data,
    () => {
        Object.keys(data.value)
            .filter((key) => data.value[key as keyof ToastMessagesData])
            .forEach((key, i) => {
                const type = key as keyof ToastMessagesData;

                setTimeout(() => {
                    toast({
                        title: titles[type],
                        description: data.value[type],
                        variant: variants[type],
                    });
                }, 250 * i);
            });
    },
    { immediate: true },
);
</script>

<template>
    <Toaster />
</template>
