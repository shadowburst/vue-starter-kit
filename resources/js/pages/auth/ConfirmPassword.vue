<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ConfirmPasswordProps, ConfirmPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.confirm_password.title'),
        description: trans('pages.auth.confirm_password.description'),
    })),
});

type Props = SharedData & ConfirmPasswordProps;
defineProps<Props>();

const form = useForm<ConfirmPasswordRequest>({
    password: '',
});

function submit() {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.confirm_password.title')" />

    <Form @submit="submit()">
        <FormContent>
            <FormField id="email" required>
                <FormLabel>Password</FormLabel>
                <FormControl>
                    <AppInput v-model="form.password" type="password" autocomplete="current-password" autofocus />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>
        </FormContent>

        <Button type="submit" :loading="form.processing">Confirm password</Button>
    </Form>
</template>
