<script setup lang="ts">
import { ResponsiveTabs, ResponsiveTabsTrigger } from '@/components/ui/custom/responsive-tabs';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Separator } from '@/components/ui/separator';
import { useLayout, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { type NavItem } from '@/types';
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

const sidebarNavItems = useRouterComputed((): NavItem[] => [
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
        <SectionContent>
            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <aside class="min-w-48">
                    <ResponsiveTabs :tabs="sidebarNavItems" orientation="vertical">
                        <ResponsiveTabsTrigger align="start" />
                    </ResponsiveTabs>
                </aside>

                <Separator class="md:hidden" />

                <div class="flex-1 md:max-w-2xl">
                    <section class="max-w-xl space-y-8">
                        <slot />
                    </section>
                </div>
            </div>
        </SectionContent>
    </Section>
</template>
