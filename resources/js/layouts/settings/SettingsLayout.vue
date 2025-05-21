<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Separator } from '@/components/ui/separator';
import { useLayout, useRouterComputed } from '@/composables';
import { AppLayout } from '@/layouts';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
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
                <aside class="w-full max-w-xl lg:w-48">
                    <nav class="flex flex-col space-y-1 space-x-0">
                        <Button
                            v-for="item in sidebarNavItems"
                            :key="item.href"
                            variant="ghost"
                            :class="['w-full justify-start', { 'bg-muted': item.isActive }]"
                            as-child
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

                <div class="flex-1 md:max-w-2xl">
                    <section class="max-w-xl space-y-8">
                        <slot />
                    </section>
                </div>
            </div>
        </SectionContent>
    </Section>
</template>
