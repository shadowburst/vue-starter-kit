<script setup lang="ts">
import AppToaster from '@/components/app/AppToaster.vue';
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

type Props = {
    title: string;
    description: string;
};
defineProps<Props>();
</script>

<template>
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link class="flex flex-col items-center gap-2 font-medium" :href="route('index')">
                        <div class="mb-1 flex size-9 items-center justify-center rounded-md">
                            <AppLogoIcon class="size-9 fill-current text-[var(--foreground)] dark:text-white" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-muted-foreground text-center text-sm">{{ description }}</p>
                    </div>
                </div>
                <slot />

                <AppToaster />
            </div>
        </div>
    </div>
</template>
