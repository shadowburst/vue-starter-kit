<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Form,
    FormContent,
    FormControl,
    FormError,
    FormField,
    FormLabel,
    FormSubmitButton,
} from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditSecuritySettingsProps, UpdatePasswordSettingsRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(SettingsLayout, () => ({})),
});

defineProps<EditSecuritySettingsProps>();

const form = useForm<UpdatePasswordSettingsRequest>({
    current_password: '',
    password: '',
    password_confirmation: '',
});

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
                <FormContent>
                    <FormField required>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.current_password') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.current_password"
                                type="password"
                                autocomplete="current-password"
                            />
                        </FormControl>
                        <FormError :message="form.errors.current_password" />
                    </FormField>
                    <FormField required>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.password') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput v-model="form.password" type="password" autocomplete="new-password" />
                        </FormControl>
                        <FormError :message="form.errors.password" />
                    </FormField>
                    <FormField required>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.password_confirmation') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.password_confirmation"
                                type="password"
                                autocomplete="new-password"
                            />
                        </FormControl>
                        <FormError :message="form.errors.password_confirmation" />
                    </FormField>
                </FormContent>
            </CardContent>
            <CardFooter>
                <FormSubmitButton />
            </CardFooter>
        </Card>
    </Form>
</template>
