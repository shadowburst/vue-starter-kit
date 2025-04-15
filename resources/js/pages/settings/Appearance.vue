<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import { useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditAppearanceSettingsProps, SharedData } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useColorMode, type BasicColorSchema } from '@vueuse/core';
import { trans } from 'laravel-vue-i18n';
import { LucideIcon, MonitorIcon, MoonIcon, SunIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(SettingsLayout, () => ({})),
});

type Props = SharedData & EditAppearanceSettingsProps;
defineProps<Props>();

const { store } = useColorMode();

type AppearanceOption = {
    value: BasicColorSchema;
    icon: LucideIcon;
    label: string;
};
const tabs: AppearanceOption[] = [
    { value: 'light', icon: SunIcon, label: trans('pages.settings.appearance.colors.light') },
    { value: 'auto', icon: MonitorIcon, label: trans('pages.settings.appearance.colors.auto') },
    { value: 'dark', icon: MoonIcon, label: trans('pages.settings.appearance.colors.dark') },
] as const;
</script>

<template>
    <Head :title="$t('pages.settings.appearance.title')" />

    <Card>
        <CardHeader>
            <CardTitle>
                {{ $t('pages.settings.appearance.title') }}
            </CardTitle>
            <CardDescription>
                {{ $t('pages.settings.appearance.description') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <ToggleGroup class="w-full" v-model="store" type="single" variant="outline">
                <ToggleGroupItem v-for="{ value, icon, label } in tabs" :key="value" :value>
                    <component class="size-4" :is="icon" />
                    <span class="text-sm">{{ label }}</span>
                </ToggleGroupItem>
            </ToggleGroup>
        </CardContent>
    </Card>
</template>
