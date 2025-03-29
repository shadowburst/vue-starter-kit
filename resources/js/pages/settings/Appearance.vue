<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import { useLayout } from '@/composables';
import { useAppearance } from '@/composables/useAppearance';
import { SettingsLayout } from '@/layouts';
import { EditAppearanceSettingsProps, SharedData } from '@/types';
import { Head } from '@inertiajs/vue3';
import { LucideIcon, MonitorIcon, MoonIcon, SunIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(SettingsLayout, {}),
});

type Props = SharedData & EditAppearanceSettingsProps;
defineProps<Props>();

const { appearance, updateAppearance } = useAppearance();

type AppearanceOption = {
    value: 'light' | 'system' | 'dark';
    icon: LucideIcon;
    label: string;
};
const tabs: AppearanceOption[] = [
    { value: 'light', icon: SunIcon, label: 'Light' },
    { value: 'system', icon: MonitorIcon, label: 'System' },
    { value: 'dark', icon: MoonIcon, label: 'Dark' },
] as const;
</script>

<template>
    <Head title="Appearance settings" />

    <Card>
        <CardHeader>
            <CardTitle> Appearance settings </CardTitle>
            <CardDescription>Update your account's appearance settings</CardDescription>
        </CardHeader>
        <CardContent>
            <ToggleGroup
                class="max-sm:flex-col max-sm:items-stretch"
                :model-value="appearance"
                type="single"
                @update:model-value="$event && updateAppearance($event as typeof appearance)"
            >
                <ToggleGroupItem v-for="{ value, icon, label } in tabs" :key="value" :value>
                    <component class="-ml-1 size-4" :is="icon" />
                    <span class="ml-1.5 text-sm">{{ label }}</span>
                </ToggleGroupItem>
            </ToggleGroup>
        </CardContent>
    </Card>
</template>
