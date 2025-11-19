<script setup lang="ts">
import { TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ResetPasswordProps, ResetPasswordRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.reset_password.title'),
        description: trans('pages.auth.reset_password.description'),
    })),
});

const props = defineProps<ResetPasswordProps>();

const form = useForm<ResetPasswordRequest>({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('password.update'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.reset_password.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionContent>
                <FormContent>
                    <TextField
                        v-model="form.email"
                        :label="$t('models.user.fields.email')"
                        type="email"
                        autocomplete="email"
                        :errors="form.errors.email"
                        :tabindex="1"
                        readonly
                    />
                    <TextField
                        v-model="form.password"
                        :label="$t('models.user.fields.password')"
                        type="password"
                        autocomplete="new-password"
                        :errors="form.errors.password"
                        :tabindex="2"
                    />
                    <TextField
                        v-model="form.password_confirmation"
                        :label="$t('models.user.fields.password_confirmation')"
                        type="password"
                        autocomplete="new-password"
                        :errors="form.errors.password_confirmation"
                        :tabindex="3"
                    />
                </FormContent>
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton :icon="false">
                    {{ $t('pages.auth.reset_password.action') }}
                </FormSubmitButton>
            </SectionFooter>
        </Section>
    </Form>
</template>
