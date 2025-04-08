<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField } from '@/components/ui/form';
import { PinInput, PinInputGroup, PinInputInput } from '@/components/ui/pin-input';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { SharedData, VerifyEmailProps, VerifyEmailRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(AuthLayout, {
        title: 'Verify email',
        description: 'Please verify your email address with the code we emailed you.',
    }),
});

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

<template>
    <Head title="Email verification" />

    <Form @submit="submit()">
        <FormContent>
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
        </FormContent>

        <div class="grid gap-2">
            <Form @submit="resend()">
                <FormContent>
                    <Button type="submit" variant="secondary" :loading="resendForm.processing">
                        Resend verification email
                    </Button>
                </FormContent>
            </Form>

            <div class="text-muted-foreground space-x-1 text-center text-sm">
                <span>Not you ? </span>
                <TextLink :href="route('logout')" method="post" as="button"> log out </TextLink>
            </div>
        </div>
    </Form>
</template>
