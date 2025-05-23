<script setup lang="ts">
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { usePage } from '@inertiajs/vue3';

const name = usePage().props.name;
</script>

<template>
    <div
        class="bg-sidebar-primary text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md"
    >
        <AppLogoIcon class="size-5 fill-current" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-none font-semibold capitalize">
            {{ name }}
        </span>
    </div>
</template>
