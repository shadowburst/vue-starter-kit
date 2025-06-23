<script setup lang="ts">
import AppToaster from '@/components/app/AppToaster.vue';
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { useAutofocus } from '@/composables';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;

type Props = {
    title: string;
    description: string;
};
defineProps<Props>();
useAutofocus();
</script>

<template>
    <div class="relative grid h-dvh flex-col items-center justify-center lg:max-w-none lg:grid-cols-2">
        <div class="bg-muted text-foreground relative hidden h-full flex-col p-10 lg:flex dark:border-r">
            <div class="bg-muted absolute inset-0" />
            <Link class="relative z-20 flex items-center text-lg font-medium" :href="route('index')">
                <AppLogoIcon class="text-foreground mr-2 size-8 fill-current" />
                {{ name }}
            </Link>
        </div>
        <div class="lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center sm:w-[400px]">
                <div class="flex flex-col space-y-2 px-4 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                    <p class="text-muted-foreground text-sm" v-if="description">{{ description }}</p>
                </div>
                <slot />

                <AppToaster />
            </div>
        </div>
    </div>
</template>
