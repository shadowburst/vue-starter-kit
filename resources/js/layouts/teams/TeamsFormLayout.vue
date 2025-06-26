<script setup lang="ts">
import { ResponsiveTabs, ResponsiveTabsTrigger } from '@/components/ui/custom/responsive-tabs';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Separator } from '@/components/ui/separator';
import { clearSessionFilters, useLayout, usePageProp, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { type NavItem } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { CalendarRangeIcon, NotebookPenIcon, SquarePenIcon, WalletIcon } from 'lucide-vue-next';

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

const sidebarNavItems = useRouterComputed((): NavItem[] =>
    [
        {
            title: trans('layouts.teams.form.edit'),
            href: route('teams.edit', { team: route().params.team }),
            icon: SquarePenIcon,
            isActive: route().current('teams.edit'),
        },
        {
            title: trans('layouts.teams.form.accounting_periods'),
            href: route('teams.accounting-periods.index', { team: route().params.team }),
            icon: CalendarRangeIcon,
            isActive: route().current('teams.accounting-periods.*'),
        },
        {
            title: trans('layouts.teams.form.project_departments'),
            href: route('teams.project-departments.index', { team: route().params.team }),
            icon: NotebookPenIcon,
            isActive: route().current('teams.project-departments.*'),
        },
        {
            title: trans('layouts.teams.form.expenses'),
            href: route('teams.expenses.categories.index', { team: route().params.team, expenseType: 'general' }),
            icon: WalletIcon,
            isActive: route().current('teams.expenses.*'),
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
        <SectionContent>
            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <aside class="min-w-48">
                    <ResponsiveTabs :tabs="sidebarNavItems" orientation="vertical" variant="ghost">
                        <ResponsiveTabsTrigger align="start" />
                    </ResponsiveTabs>
                </aside>

                <Separator class="md:hidden" />

                <div class="flex-1">
                    <section class="space-y-8 *:not-[.w-full]:max-w-xl">
                        <slot />
                    </section>
                </div>
            </div>
        </SectionContent>
    </Section>
</template>
