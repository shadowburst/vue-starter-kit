<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Checkbox } from '@/components/ui/checkbox';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { LoginProps, LoginRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { CheckIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AuthLayout, {
        title: 'Log in to your account',
        description: 'Enter your email and password below to log in',
    }),
});

type Props = SharedData & LoginProps;
defineProps<Props>();

const form = useForm<LoginRequest>({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head title="Login" />

    <Alert class="mb-6" v-if="status" variant="primary">
        <CheckIcon class="size-4" />
        <AlertTitle>
            {{ status }}
        </AlertTitle>
    </Alert>

    <Form @submit="submit()">
        <FormField id="email" required>
            <FormLabel class="after:!content-['']">Email address</FormLabel>
            <FormControl>
                <Input v-model="form.email" type="email" autofocus autocomplete="email" :tabindex="1" />
            </FormControl>
            <FormError :message="form.errors.email" />
        </FormField>
        <FormField id="password" required>
            <div class="flex items-center justify-between">
                <FormLabel class="after:!content-['']">Password</FormLabel>
                <Link class="text-sm" v-if="canResetPassword" :href="route('password.request')" :tabindex="2">
                    Forgot password?
                </Link>
            </div>
            <FormControl>
                <Input v-model="form.password" type="password" autocomplete="current-password" :tabindex="1" />
            </FormControl>
            <FormError :message="form.errors.password" />
        </FormField>

        <FormField id="remember">
            <FormLabel>
                <FormControl>
                    <Checkbox v-model="form.remember" :tabindex="1" />
                </FormControl>
                <span>Remember me</span>
            </FormLabel>
        </FormField>

        <LoadingButton type="submit" :loading="form.processing" :tabindex="1"> Log in </LoadingButton>

        <div class="text-center text-sm text-muted-foreground">
            Don't have an account?
            <Link :href="route('register')" :tabindex="2">Sign up</Link>
        </div>
    </Form>
</template>
