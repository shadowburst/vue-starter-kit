<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { useLayout } from '@/composables/useLayout';
import { RegisterProps, RegisterRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

type Props = SharedData & RegisterProps;
defineProps<Props>();

useLayout({
    title: 'Create an account',
    description: 'Enter your details below to create your account',
});

const form = useForm<RegisterRequest>({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head title="Register" />

    <Form @submit="submit()">
        <FormField id="first_name" required>
            <FormLabel>First name</FormLabel>
            <FormControl>
                <Input v-model="form.first_name" autofocus autocomplete="given-name" />
            </FormControl>
            <FormError :message="form.errors.first_name" />
        </FormField>
        <FormField id="last_name" required>
            <FormLabel>Last name</FormLabel>
            <FormControl>
                <Input v-model="form.last_name" autocomplete="family-name" />
            </FormControl>
            <FormError :message="form.errors.last_name" />
        </FormField>
        <FormField id="email" required>
            <FormLabel>Email</FormLabel>
            <FormControl>
                <Input v-model="form.email" type="email" autocomplete="email" />
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

        <LoadingButton type="submit" :loading="form.processing"> Create account </LoadingButton>

        <div class="text-center text-sm text-muted-foreground">
            Already have an account?
            <Link :href="route('login')">Log in</Link>
        </div>
    </Form>
</template>
