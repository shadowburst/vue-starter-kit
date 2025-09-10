<script setup lang="ts">
import { ResponsiveTabs, ResponsiveTabsTrigger } from '@/components/ui/custom/responsive-tabs';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Separator } from '@/components/ui/separator';
import { useLayout, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { NavItemHref } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { PaletteIcon, ShieldPlusIcon, UserIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.settings.title'),
                href: route('settings.index'),
            },
        ],
    })),
});

const sidebarNavItems = useRouterComputed((): NavItemHref[] => [
    {
        title: trans('layouts.settings.profile'),
        href: route('settings.profile.edit'),
        icon: UserIcon,
        isActive: route().current('settings.profile.edit'),
    },
    {
        title: trans('layouts.settings.security'),
        href: route('settings.security.edit'),
        icon: ShieldPlusIcon,
        isActive: route().current('settings.security.edit'),
    },
    {
        title: trans('layouts.settings.appearance'),
        href: route('settings.appearance.edit'),
        icon: PaletteIcon,
        isActive: route().current('settings.appearance.edit'),
    },
]);
</script>

<template>
    <Section>
        <SectionContent class="flex flex-col gap-x-8 gap-y-4 md:flex-row">
            <aside class="min-w-48">
                <ResponsiveTabs :tabs="sidebarNavItems" orientation="vertical" variant="ghost">
                    <ResponsiveTabsTrigger align="start" />
                </ResponsiveTabs>
            </aside>

            <Separator class="md:hidden" />

            <div class="flex-1 space-y-8 *:not-[.w-full]:max-w-xl">
                <slot />
            </div>
        </SectionContent>
    </Section>
</template>
