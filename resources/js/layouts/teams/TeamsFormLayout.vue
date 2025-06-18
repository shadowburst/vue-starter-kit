<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Separator } from '@/components/ui/separator';
import { clearSessionFilters, useLayout, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
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
                title: route().params.team,
                href: route('teams.edit', { team: route().params.team }),
            },
        ],
    })),
});

const sidebarNavItems = useRouterComputed((): NavItem[] => [
    {
        title: trans('layouts.teams.form.edit'),
        href: route('teams.edit', { team: route().params.team }),
        icon: SquarePenIcon,
        isActive: route().current('teams.edit'),
    },
]);
</script>

<template>
    <Section>
        <SectionContent>
            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <aside class="w-full max-w-xl lg:w-48">
                    <nav class="flex flex-col space-y-1 space-x-0">
                        <Button
                            v-for="item in sidebarNavItems"
                            :key="item.href"
                            variant="ghost"
                            :class="['w-full justify-start', { 'bg-muted': item.isActive }]"
                            as-child
                            @click="clearSessionFilters(item.href)"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" />
                                <CapitalizeText>
                                    {{ item.title }}
                                </CapitalizeText>
                            </Link>
                        </Button>
                    </nav>
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
