<script setup lang="ts">
import { OTPField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { VerifyEmailProps, VerifyEmailRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.verify_email.title'),
        description: trans('pages.auth.verify_email.description'),
    })),
});

defineProps<VerifyEmailProps>();

const resendForm = useForm({});

function resend() {
    resendForm.post(route('verification.send'));
}

const form = useForm<VerifyEmailRequest>({
    code: '',
});

function submit() {
    form.clearErrors();
    form.post(route('verification.code'), {
        onError: () => form.reset(),
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.verify_email.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionContent>
                <FormContent>
                    <OTPField v-model="form.code" :errors="form.errors.code" required class="mx-auto w-auto" />
                </FormContent>
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton :icon="false">
                    {{ $t('verify') }}
                </FormSubmitButton>
                <Form class="grid" :form="resendForm" @submit="resend()">
                    <FormSubmitButton variant="secondary" :icon="false">
                        {{ $t('pages.auth.verify_email.resend_email') }}
                    </FormSubmitButton>
                </Form>

                <div class="text-muted-foreground space-x-1 text-center text-sm">
                    {{ $t('pages.auth.verify_email.not_you') }}
                    <CapitalizeText as-child>
                        <TextLink :href="route('logout')" method="post" as="button">
                            {{ $t('logout') }}
                        </TextLink>
                    </CapitalizeText>
                </div>
            </SectionFooter>
        </Section>
    </Form>
</template>
