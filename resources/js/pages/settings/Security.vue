<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditSecuritySettingsProps, SharedData, UpdatePasswordSettingsRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { SaveIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(SettingsLayout, () => ({})),
});

type Props = SharedData & EditSecuritySettingsProps;
defineProps<Props>();

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

    <Form @submit="submit()">
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
                    <FormField id="current_password" required>
                        <FormLabel>
                            {{ $t('models.user.fields.current_password') }}
                        </FormLabel>
                        <FormControl>
                            <AppInput v-model="form.current_password" type="password" autocomplete="current-password" />
                        </FormControl>
                        <FormError :message="form.errors.current_password" />
                    </FormField>
                    <FormField id="password" required>
                        <FormLabel>
                            {{ $t('models.user.fields.password') }}
                        </FormLabel>
                        <FormControl>
                            <AppInput v-model="form.password" type="password" autocomplete="new-password" />
                        </FormControl>
                        <FormError :message="form.errors.password" />
                    </FormField>
                    <FormField id="password_confirmation" required>
                        <FormLabel>
                            {{ $t('models.user.fields.password_confirmation') }}
                        </FormLabel>
                        <FormControl>
                            <AppInput
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
                <Button type="submit" :loading="form.processing" :icon="SaveIcon">
                    <Capitalize>
                        {{ $t('save') }}
                    </Capitalize>
                </Button>
            </CardFooter>
        </Card>
    </Form>
</template>
