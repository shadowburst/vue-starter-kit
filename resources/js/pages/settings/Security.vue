<script setup lang="ts">
import { PasswordSettingsForm } from '@/components/settings/security';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { useLayout } from '@/composables';
import { usePasswordSettingsForm } from '@/composables/settings';
import { SettingsLayout } from '@/layouts';
import { EditSecuritySettingsProps } from '@/types';
import { Head } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(SettingsLayout, () => ({})),
});

defineProps<EditSecuritySettingsProps>();

const form = usePasswordSettingsForm();

function submit() {
    form.patch(route('settings.password.update'), {
        onFinish: () => form.reset(),
    });
}
</script>

<template>
    <Head :title="$t('pages.settings.security.title')" />

    <Form :form @submit="submit()">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ $t('pages.settings.security.password.title') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('pages.settings.security.password.description') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <PasswordSettingsForm />
            </CardContent>
            <CardFooter>
                <FormSubmitButton />
            </CardFooter>
        </Card>
    </Form>
</template>
