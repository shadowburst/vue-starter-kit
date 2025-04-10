<script setup lang="ts">
import AppToaster from '@/components/app/AppToaster.vue';
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;

type Props = {
    title: string;
    description: string;
};
defineProps<Props>();
</script>

<template>
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0"
    >
        <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-r">
            <div class="bg-muted absolute inset-0" />
            <Link class="relative z-20 flex items-center text-lg font-medium" :href="route('home')">
                <AppLogoIcon class="mr-2 size-8 fill-current text-white" />
                {{ name }}
            </Link>
        </div>
        <div class="lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                    <p class="text-muted-foreground text-sm" v-if="description">{{ description }}</p>
                </div>
                <slot />

                <AppToaster />
            </div>
        </div>
    </div>
</template>
