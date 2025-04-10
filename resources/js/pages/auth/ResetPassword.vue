<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ResetPasswordProps, ResetPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(AuthLayout, {
        title: 'Reset password',
        description: 'Please enter your new password below',
    }),
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
    <Head title="Reset password" />

    <Form @submit="submit()">
        <FormContent>
            <FormField id="email" required>
                <FormLabel>Email</FormLabel>
                <FormControl>
                    <AppInput v-model="form.email" type="email" autocomplete="email" readonly />
                </FormControl>
                <FormError :message="form.errors.email" />
            </FormField>
            <FormField id="password" required>
                <FormLabel>Password</FormLabel>
                <FormControl>
                    <AppInput v-model="form.password" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>
            <FormField id="password_confirmation" required>
                <FormLabel>Confirm password</FormLabel>
                <FormControl>
                    <AppInput v-model="form.password_confirmation" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password_confirmation" />
            </FormField>
        </FormContent>

        <Button type="submit" :loading="form.processing">Reset password</Button>
    </Form>
</template>
