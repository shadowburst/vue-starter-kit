<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ConfirmPasswordProps, ConfirmPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(AuthLayout, {
        title: 'Confirm your password',
        description: 'This is a secure area of the application. Please confirm your password before continuing.',
    }),
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
    <Head title="Confirm password" />

    <Form @submit="submit()">
        <FormField id="email" required>
            <FormLabel>Password</FormLabel>
            <FormControl>
                <Input v-model="form.password" type="password" autocomplete="current-password" autofocus />
            </FormControl>
            <FormError :message="form.errors.password" />
        </FormField>

        <LoadingButton type="submit" :loading="form.processing">Confirm password</LoadingButton>
    </Form>
</template>
