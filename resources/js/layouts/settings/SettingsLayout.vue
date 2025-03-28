<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useLayout, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { PaletteIcon, ShieldPlusIcon, UserIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AppLayout, {
        breadcrumbs: [
            {
                title: 'Settings',
                href: route('settings.index'),
            },
        ],
    }),
});

const sidebarNavItems = useRouterComputed((): NavItem[] => [
    {
        title: 'Profile',
        href: route('settings.profile.edit'),
        icon: UserIcon,
        isActive: route().current('settings.profile.edit'),
    },
    {
        title: 'Security',
        href: route('settings.security.edit'),
        icon: ShieldPlusIcon,
        isActive: route().current('settings.security.edit'),
    },
    {
        title: 'Appearance',
        href: route('settings.appearance'),
        icon: PaletteIcon,
        isActive: route().current('settings.appearance'),
    },
]);
</script>

<template>
    <div>
        <Heading title="Settings" description="Manage your profile and account settings" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-x-12 lg:space-y-0">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-x-0 space-y-1">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': item.isActive }]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component class="size-5" :is="item.icon" />
                            <Capitalize>
                                {{ item.title }}
                            </Capitalize>
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
