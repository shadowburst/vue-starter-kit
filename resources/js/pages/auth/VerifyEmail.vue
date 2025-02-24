<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};
</script>

<template>
    <AuthLayout
        title="Verify email"
        description="Please verify your email address by clicking on the link we just emailed to you."
    >
        <Head title="Email verification" />

        <div class="mb-4 text-center text-sm font-medium text-green-600" v-if="status === 'verification-link-sent'">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form class="space-y-6 text-center" @submit.prevent="submit">
            <Button :disabled="form.processing" variant="secondary">
                <LoaderCircle class="h-4 w-4 animate-spin" v-if="form.processing" />
                Resend verification email
            </Button>

            <TextLink class="mx-auto block text-sm" :href="route('logout')" method="post" as="button">
                Log out
            </TextLink>
        </form>
    </AuthLayout>
</template>
