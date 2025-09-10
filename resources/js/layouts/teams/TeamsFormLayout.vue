<script setup lang="ts">
import { ResponsiveTabs, ResponsiveTabsTrigger } from '@/components/ui/custom/responsive-tabs';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Separator } from '@/components/ui/separator';
import { clearSessionFilters, useLayout, usePageProp, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { NavItemHref } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { SquarePenIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.teams.index.title'),
                href: route('teams.index'),
            },
            {
                title: usePageProp<string>('team.name', route().params.team).value,
                href: route('teams.edit', { team: route().params.team }),
            },
        ],
    })),
});

const sidebarNavItems = useRouterComputed((): NavItemHref[] =>
    [
        {
            title: trans('layouts.teams.form.edit'),
            href: route('teams.edit', { team: route().params.team }),
            icon: SquarePenIcon,
            isActive: route().current('teams.edit'),
        },
    ].map((item) =>
        Object.assign(item, {
            options: {
                onBefore: () => clearSessionFilters(item.href),
            },
        }),
    ),
);
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
