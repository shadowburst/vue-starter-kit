<script setup lang="ts">
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormContent, FormControl, FormDescription, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { useAuth, useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditProfileSettingsProps, SharedData, UpdateProfileSettingsRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { SaveIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(SettingsLayout, {}),
});

type Props = SharedData & EditProfileSettingsProps;
defineProps<Props>();

const auth = useAuth();

const form = useForm<UpdateProfileSettingsRequest>({
    first_name: auth.value.user.first_name,
    last_name: auth.value.user.last_name,
    email: auth.value.user.email,
});

function submit() {
    form.post(route('settings.profile.update'));
}
</script>

<template>
    <Head title="Profile settings" />

    <Form @submit="submit()">
        <Card>
            <CardHeader>
                <CardTitle> Profile information </CardTitle>
                <CardDescription>Update your name and email address</CardDescription>
            </CardHeader>
            <CardContent>
                <FormContent>
                    <FormField id="first_name" required>
                        <FormLabel>
                            {{ $t('models.user.fields.first_name') }}
                        </FormLabel>
                        <FormControl>
                            <Input v-model="form.first_name" autocomplete="given-name" />
                        </FormControl>
                        <FormError :message="form.errors.first_name" />
                    </FormField>
                    <FormField id="last_name" required>
                        <FormLabel>
                            {{ $t('models.user.fields.last_name') }}
                        </FormLabel>
                        <FormControl>
                            <Input v-model="form.last_name" autocomplete="family-name" />
                        </FormControl>
                        <FormError :message="form.errors.last_name" />
                    </FormField>
                    <FormField id="email" required>
                        <FormLabel>
                            {{ $t('models.user.fields.email') }}
                        </FormLabel>
                        <FormControl>
                            <Input v-model="form.email" type="email" autocomplete="email" />
                        </FormControl>
                        <FormError :message="form.errors.email" />
                        <FormDescription v-if="mustVerifyEmail">
                            Your email address is unverified.
                            <Link :href="route('verification.notice')">
                                Click here to resend the verification email.
                            </Link>
                        </FormDescription>
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
