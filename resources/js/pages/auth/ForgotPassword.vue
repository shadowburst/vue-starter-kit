<template>
    <Head title="Forgot password" />

    <div class="mb-4 text-center text-sm font-medium text-green-600" v-if="status">
        {{ status }}
    </div>

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

<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Form, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link } from '@/components/ui/link';
import { ForgotPasswordProps, ForgotPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

type Props = SharedData & ForgotPasswordProps;
defineProps<Props>();

const form = useForm<ForgotPasswordRequest>({
    email: '',
});

function submit() {
    form.post(route('password.email'));
}
</script>
