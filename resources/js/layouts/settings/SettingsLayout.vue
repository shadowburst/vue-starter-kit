<script setup lang="ts">
import { ResponsiveTabs, ResponsiveTabsTrigger } from '@/components/ui/custom/responsive-tabs';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Separator } from '@/components/ui/separator';
import { useInertiaComputed, useLayout } from '@/composables';
import { AppLayout } from '@/layouts';
import settings from '@/routes/settings';
import { NavItemHref } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { PaletteIcon, ShieldPlusIcon, UserIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.settings.title'),
                href: settings.index.url(),
            },
        ],
    })),
});

const sidebarNavItems = useInertiaComputed((): NavItemHref[] => [
    {
        title: trans('layouts.settings.account'),
        href: settings.account.edit.url(),
        icon: UserIcon,
    },
    {
        title: trans('layouts.settings.security'),
        href: settings.security.edit.url(),
        icon: ShieldPlusIcon,
    },
    {
        title: trans('layouts.settings.appearance'),
        href: settings.appearance.edit.url(),
        icon: PaletteIcon,
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
