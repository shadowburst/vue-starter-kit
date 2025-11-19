<script setup lang="ts">
import { Alert, AlertTitle } from '@/components/ui/alert';
import { TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter, SectionHeader } from '@/components/ui/custom/section';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ForgotPasswordProps, ForgotPasswordRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { CheckIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.forgot_password.title'),
        description: trans('pages.auth.forgot_password.description'),
    })),
});

defineProps<ForgotPasswordProps>();

const form = useForm<ForgotPasswordRequest>({
    email: '',
});

function submit() {
    form.post(route('password.email'));
}
</script>

<template>
    <Head :title="$t('pages.auth.forgot_password.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader v-if="status">
                <Alert variant="primary">
                    <CheckIcon class="size-4" />
                    <AlertTitle class="line-clamp-none">
                        {{ status }}
                    </AlertTitle>
                </Alert>
            </SectionHeader>
            <SectionContent>
                <FormContent>
                    <TextField
                        v-model="form.email"
                        :label="$t('models.user.fields.email')"
                        type="email"
                        autocomplete="off"
                        :errors="form.errors.email"
                        :tabindex="1"
                        autofocus
                    />
                </FormContent>
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton :icon="false">
                    {{ $t('pages.auth.forgot_password.email_link') }}
                </FormSubmitButton>
                <div class="text-muted-foreground space-x-1 text-center text-sm">
                    <span>
                        {{ $t('pages.auth.forgot_password.return_to') }}
                    </span>
                    <TextLink :href="route('login')">
                        {{ $t('login') }}
                    </TextLink>
                </div>
            </SectionFooter>
        </Section>
    </Form>
</template>
