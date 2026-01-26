<script setup lang="ts">
import { ResponsiveTabs, ResponsiveTabsTrigger } from '@/components/ui/custom/responsive-tabs';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { Separator } from '@/components/ui/separator';
import { useInertiaComputed, useLayout, usePageProp } from '@/composables';
import { AppLayout } from '@/layouts';
import teams from '@/routes/teams';
import { NavItemHref, TeamResource } from '@/types';
import { trans } from 'laravel-vue-i18n';
import { SquarePenIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AppLayout, () => {
        const team = usePageProp<TeamResource>('team');
        if (!team.value) {
            return {};
        }

        return {
            breadcrumbs: [
                {
                    title: trans('pages.teams.index.title'),
                    href: teams.index.url(),
                },
                {
                    title: team.value.name,
                    href: teams.edit.url({ team: team.value.id }),
                },
            ],
        };
    }),
});

const team = usePageProp<TeamResource>('team');

const sidebarNavItems = useInertiaComputed((): NavItemHref[] =>
    team.value
        ? [
              {
                  title: trans('layouts.teams.form.edit'),
                  href: teams.edit.url({ team: team.value }),
                  icon: SquarePenIcon,
              },
          ]
        : [],
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
