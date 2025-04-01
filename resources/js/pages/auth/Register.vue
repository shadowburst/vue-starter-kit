<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { RegisterProps, RegisterRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(AuthLayout, {
        title: 'Create an account',
        description: 'Enter your details below to create your account',
    }),
});

type Props = SharedData & RegisterProps;
defineProps<Props>();

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
        <FormContent>
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
        </FormContent>

        <div class="grid gap-2">
            <Button type="submit" :loading="form.processing"> Create account </Button>
            <div class="text-muted-foreground text-center text-sm">
                Already have an account?
                <Link :href="route('login')">Log in</Link>
            </div>
        </div>
    </Form>
</template>
