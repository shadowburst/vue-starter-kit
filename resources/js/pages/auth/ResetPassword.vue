<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { TextInput } from '@/components/ui/custom/input';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ResetPasswordProps, ResetPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.reset_password.title'),
        description: trans('pages.auth.reset_password.description'),
    })),
});

type Props = SharedData & ResetPasswordProps;
const props = defineProps<Props>();

const form = useForm<ResetPasswordRequest>({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('password.update'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.reset_password.title')" />

    <Form @submit="submit()">
        <FormContent>
            <FormField id="email" required>
                <FormLabel>
                    {{ $t('models.user.fields.email') }}
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.email" type="email" autocomplete="email" readonly />
                </FormControl>
                <FormError :message="form.errors.email" />
            </FormField>
            <FormField id="password" required>
                <FormLabel>
                    {{ $t('models.user.fields.password') }}
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.password" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>
            <FormField id="password_confirmation" required>
                <FormLabel>
                    {{ $t('models.user.fields.password_confirmation') }}
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.password_confirmation" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password_confirmation" />
            </FormField>
        </FormContent>

        <Button type="submit" :loading="form.processing">
            {{ $t('pages.auth.reset_password.action') }}
        </Button>
    </Form>
</template>
