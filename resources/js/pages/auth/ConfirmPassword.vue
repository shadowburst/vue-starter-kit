<script setup lang="ts">
import { TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ConfirmPasswordProps, ConfirmPasswordRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.confirm_password.title'),
        description: trans('pages.auth.confirm_password.description'),
    })),
});

defineProps<ConfirmPasswordProps>();

const form = useForm<ConfirmPasswordRequest>({
    password: '',
});

function submit() {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.confirm_password.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionContent>
                <FormContent>
                    <TextField
                        v-model="form.password"
                        :label="$t('models.user.fields.password')"
                        type="password"
                        autocomplete="current-password"
                        :errors="form.errors.password"
                        :tabindex="1"
                        autofocus
                    />
                </FormContent>
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton :icon="false">
                    {{ $t('pages.auth.confirm_password.action') }}
                </FormSubmitButton>
            </SectionFooter>
        </Section>
    </Form>
</template>
