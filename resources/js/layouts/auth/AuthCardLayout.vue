<script setup lang="ts">
import AppToaster from '@/components/app/AppToaster.vue';
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Link } from '@inertiajs/vue3';

type Props = {
    title: string;
    description: string;
};
defineProps<Props>();
</script>

<template>
    <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-md flex-col gap-6">
            <Link class="flex items-center gap-2 self-center font-medium" :href="route('index')">
                <div class="flex size-9 items-center justify-center">
                    <AppLogoIcon class="size-9 fill-current text-black dark:text-white" />
                </div>
            </Link>

            <div class="flex flex-col gap-6">
                <Card class="rounded-xl">
                    <CardHeader class="px-10 pt-8 pb-0 text-center">
                        <CardTitle class="text-xl">{{ title }}</CardTitle>
                        <CardDescription>
                            {{ description }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="px-10 py-8">
                        <slot />

                        <AppToaster />
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
