<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import { useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditAppearanceSettingsProps, SharedData } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useColorMode, type BasicColorSchema } from '@vueuse/core';
import { LucideIcon, MonitorIcon, MoonIcon, SunIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(SettingsLayout, {}),
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
    { value: 'light', icon: SunIcon, label: 'Light' },
    { value: 'auto', icon: MonitorIcon, label: 'System' },
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
            <ToggleGroup class="max-sm:flex-col max-sm:items-stretch" v-model="store" type="single" variant="outline">
                <ToggleGroupItem class="min-w-28" v-for="{ value, icon, label } in tabs" :key="value" :value>
                    <component class="size-4" :is="icon" />
                    <span class="text-sm">{{ label }}</span>
                </ToggleGroupItem>
            </ToggleGroup>
        </CardContent>
    </Card>
</template>
