<template>
    <Head title="Reset password" />

    <Form @submit="submit()">
        <FormField id="email" required>
            <FormLabel>Email</FormLabel>
            <FormControl>
                <Input v-model="form.email" type="email" autocomplete="email" readonly />
            </FormControl>
            <FormError :message="form.errors.email" />
        </FormField>
        <FormField id="password" required>
            <FormLabel>Password</FormLabel>
            <FormControl>
                <Input v-model="form.password" type="password" autocomplete="new-password" />
            </FormControl>
            <FormError :message="form.errors.password" />
        </FormField>
        <FormField id="password_confirmation" required>
            <FormLabel>Confirm password</FormLabel>
            <FormControl>
                <Input v-model="form.password_confirmation" type="password" autocomplete="new-password" />
            </FormControl>
            <FormError :message="form.errors.password_confirmation" />
        </FormField>

        <LoadingButton type="submit" :loading="form.processing">Reset password</LoadingButton>
    </Form>
</template>

<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { ResetPasswordProps, ResetPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

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
