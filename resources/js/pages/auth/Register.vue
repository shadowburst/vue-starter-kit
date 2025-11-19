<script setup lang="ts">
import { TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { RegisterProps, RegisterRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.register.title'),
        description: trans('pages.auth.register.description'),
    })),
});

defineProps<RegisterProps>();

const form = useForm<RegisterRequest>({
    first_name: '',
    last_name: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.register.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionContent>
                <FormContent>
                    <TextField
                        v-model="form.first_name"
                        :label="$t('models.user.fields.first_name')"
                        type="text"
                        autocomplete="given-name"
                        :errors="form.errors.first_name"
                        :tabindex="1"
                        autofocus
                    />
                    <TextField
                        v-model="form.last_name"
                        :label="$t('models.user.fields.last_name')"
                        type="text"
                        autocomplete="family-name"
                        :errors="form.errors.last_name"
                        :tabindex="2"
                    />
                    <TextField
                        v-model="form.phone"
                        :label="$t('models.user.fields.phone')"
                        type="tel"
                        autocomplete="phone"
                        :errors="form.errors.phone"
                        :tabindex="3"
                    />
                    <TextField
                        v-model="form.email"
                        :label="$t('models.user.fields.email')"
                        type="email"
                        autocomplete="email"
                        :errors="form.errors.email"
                        :tabindex="4"
                    />
                    <TextField
                        v-model="form.password"
                        :label="$t('models.user.fields.password')"
                        type="password"
                        autocomplete="new-password"
                        :errors="form.errors.password"
                        :tabindex="5"
                    />
                    <TextField
                        v-model="form.password_confirmation"
                        :label="$t('models.user.fields.password_confirmation')"
                        type="password"
                        autocomplete="new-password"
                        :errors="form.errors.password_confirmation"
                        :tabindex="6"
                    />
                </FormContent>
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton :icon="false">
                    {{ $t('pages.auth.register.action') }}
                </FormSubmitButton>
                <div class="text-muted-foreground text-center text-sm">
                    {{ $t('pages.auth.register.has_account') }}
                    <CapitalizeText>
                        <TextLink :href="route('login')">
                            {{ $t('login') }}
                        </TextLink>
                    </CapitalizeText>
                </div>
            </SectionFooter>
        </Section>
    </Form>
</template>
