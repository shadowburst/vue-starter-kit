<script setup lang="ts">
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField } from '@/components/ui/form';
import { TextLink } from '@/components/ui/link';
import { PinInput, PinInputGroup, PinInputSlot } from '@/components/ui/pin-input';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { SharedData, VerifyEmailProps, VerifyEmailRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.verify_email.title'),
        description: trans('pages.auth.verify_email.description'),
    })),
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
    <Head :title="trans('pages.auth.verify_email.title')" />

    <Form @submit="submit()">
        <FormContent>
            <FormField id="code" required :disabled="form.processing">
                <FormControl>
                    <PinInput v-model="form.code" otp type="number" placeholder="○" @complete="submit()">
                        <PinInputGroup>
                            <PinInputSlot class="size-14 text-xl" v-for="(key, index) in 6" :key :index />
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
                        {{ $t('pages.auth.verify_email.resend_email') }}
                    </Button>
                </FormContent>
            </Form>

            <div class="text-muted-foreground space-x-1 text-center text-sm">
                {{ $t('pages.auth.verify_email.not_you') }}
                <Capitalize as-child>
                    <TextLink :href="route('logout')" method="post" as="button">
                        {{ $t('logout') }}
                    </TextLink>
                </Capitalize>
            </div>
        </div>
    </Form>
</template>
