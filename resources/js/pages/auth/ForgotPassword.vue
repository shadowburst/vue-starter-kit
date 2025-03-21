<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Alert } from '@/components/ui/alert';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { useLayout } from '@/composables/useLayout';
import { ForgotPasswordProps, ForgotPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { CheckIcon } from 'lucide-vue-next';

type Props = SharedData & ForgotPasswordProps;
defineProps<Props>();

useLayout({
    title: 'Forgot password',
    description: 'Enter your email to receive a password reset link',
});

const form = useForm<ForgotPasswordRequest>({
    email: '',
});

function submit() {
    form.post(route('password.email'));
}
</script>

<template>
    <Head title="Forgot password" />

    <Alert class="mb-6" v-if="status" variant="primary">
        <CheckIcon class="size-4" />
        <AlertTitle>
            {{ status }}
        </AlertTitle>
    </Alert>

    <Form @submit="submit()">
        <FormField id="email" required>
            <FormLabel>Email address</FormLabel>
            <FormControl>
                <Input v-model="form.email" type="email" autocomplete="off" autofocus />
            </FormControl>
            <FormError :message="form.errors.email" />
        </FormField>

        <LoadingButton type="submit" :loading="form.processing"> Email password reset link </LoadingButton>

        <div class="space-x-1 text-center text-sm text-muted-foreground">
            <span>Or, return to</span>
            <Link :href="route('login')">log in</Link>
        </div>
    </Form>
</template>
