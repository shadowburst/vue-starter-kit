<script setup lang="ts">
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { useAuth, usePageProp } from '@/composables';

const name = usePageProp<string>('name');

const { team } = useAuth();
</script>

<template>
    <div
        class="bg-sidebar-primary text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md"
    >
        <AppLogoIcon class="size-5 fill-current" />
    </div>
    <div class="ml-1 grid flex-1 gap-0.5 text-left text-sm">
        <span class="truncate leading-tight font-semibold capitalize">
            {{ name }}
        </span>
        <span class="truncate text-xs leading-none capitalize">
            {{ team.name }}
        </span>
    </div>
</template>
