<script setup lang="ts">
import { Form, FormContent, FormControl, FormError, FormField, FormSubmitButton } from '@/components/ui/custom/form';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { PinInput, PinInputGroup, PinInputSlot } from '@/components/ui/pin-input';
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

const form = useForm({
    code: [] as number[],
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

    <Form :form @submit="submit()">
        <Section>
            <SectionContent>
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
            </SectionContent>
            <SectionFooter class="grid">
                <Form class="grid" :form="resendForm" @submit="resend()">
                    <FormSubmitButton variant="secondary">
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
