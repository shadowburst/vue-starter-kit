<template>
    <Head title="Email verification" />

    <Form @submit="resend()">
        <LoadingButton type="submit" variant="secondary" :loading="resendForm.processing">
            Resend verification email
        </LoadingButton>
        <Link :href="route('logout')" method="post" as="button"> Log out </Link>
    </Form>

    <Form @submit="submit()">
        <FormField id="code" required :disabled="form.processing">
            <FormControl>
                <PinInput v-model="form.code" otp type="number" placeholder="○" @complete="submit()">
                    <PinInputGroup>
                        <PinInputInput class="size-14 text-xl" v-for="(key, index) in 6" :key :index />
                    </PinInputGroup>
                </PinInput>
            </FormControl>
            <FormError :message="form.errors.code" />
        </FormField>
    </Form>
</template>

<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Form, FormControl, FormError, FormField } from '@/components/ui/form';
import { Link } from '@/components/ui/link';
import { PinInput, PinInputGroup, PinInputInput } from '@/components/ui/pin-input';
import { SharedData, VerifyEmailProps, VerifyEmailRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

type Props = SharedData & VerifyEmailProps;
defineProps<Props>();

const resendForm = useForm({});

function resend() {
    resendForm.post(route('verification.send'));
}

const form = useForm({
    code: [] as string[],
}).transform((data): VerifyEmailRequest => ({ code: data.code.join('') }));

function submit() {
    form.clearErrors();
    form.post(route('verification.code'), {
        onError: () => form.reset(),
    });
}
</script>
