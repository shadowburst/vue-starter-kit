<template>
    <Head title="Log in" />

    <div class="mb-4 text-center text-sm font-medium text-green-600" v-if="status">
        {{ status }}
    </div>

    <Form @submit="submit()">
        <FormField name="email" required>
            <FormLabel class="after:!content-['']">Email address</FormLabel>
            <FormControl>
                <Input v-model="form.email" type="email" autofocus :tabindex="1" autocomplete="email" />
            </FormControl>
            <FormError :message="form.errors.email" />
        </FormField>
        <FormField name="password" required>
            <div class="flex items-center justify-between">
                <FormLabel class="after:!content-['']">Password</FormLabel>
                <Link class="text-sm" v-if="canResetPassword" :href="route('password.request')" :tabindex="5">
                    Forgot password?
                </Link>
            </div>
            <FormControl>
                <Input v-model="form.password" type="password" :tabindex="2" autocomplete="current-password" />
            </FormControl>
            <FormError :message="form.errors.password" />
        </FormField>

        <FormField name="remember">
            <FormLabel>
                <FormControl>
                    <Checkbox v-model="form.remember" :tabindex="4" />
                </FormControl>
                <span>Remember me</span>
            </FormLabel>
        </FormField>

        <LoadingButton type="submit" :loading="form.processing" :tabindex="4"> Log in </LoadingButton>

        <div class="text-center text-sm text-muted-foreground">
            Don't have an account?
            <Link :href="route('register')" :tabindex="5">Sign up</Link>
        </div>
    </Form>
</template>

<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
