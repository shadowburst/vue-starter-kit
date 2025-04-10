<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ForgotPasswordProps, ForgotPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { CheckIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AuthLayout, {
        title: 'Forgot password',
        description: 'Enter your email to receive a password reset link',
    }),
});

type Props = SharedData & ForgotPasswordProps;
defineProps<Props>();

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
        <FormContent>
            <FormField id="email" required>
                <FormLabel>Email address</FormLabel>
                <FormControl>
                    <AppInput v-model="form.email" type="email" autocomplete="off" autofocus />
                </FormControl>
                <FormError :message="form.errors.email" />
            </FormField>
        </FormContent>

        <div class="grid gap-2">
            <Button type="submit" :loading="form.processing"> Email password reset link </Button>
            <div class="text-muted-foreground space-x-1 text-center text-sm">
                <span>Or, return to</span>
                <TextLink :href="route('login')">log in</TextLink>
            </div>
        </div>
    </Form>
</template>
