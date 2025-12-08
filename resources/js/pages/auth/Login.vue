<script setup lang="ts">
import { Alert, AlertTitle } from '@/components/ui/alert';
import { CheckboxField, TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormControl, FormError, FormLabel, FormSubmitButton } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter, SectionHeader } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { LoginProps, LoginRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { CheckIcon, LogInIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.login.title'),
        description: trans('pages.auth.login.description'),
    })),
});

defineProps<LoginProps>();

const form = useForm<LoginRequest>({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.login.title')" />

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
                        :errors="form.errors.email"
                        type="email"
                        autofocus
                        autocomplete="email"
                        :tabindex="1"
                    />
                    <TextField :label="$t('models.user.fields.password')" :errors="form.errors.password" :tabindex="2">
                        <div class="flex items-center justify-between">
                            <FormLabel />
                            <TextLink
                                class="text-sm"
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                :tabindex="5"
                            >
                                {{ $t('pages.auth.login.forgot_password') }}
                            </TextLink>
                        </div>
                        <FormControl>
                            <TextInput v-model="form.password" type="password" autocomplete="current-password" />
                        </FormControl>
                        <FormError />
                    </TextField>
                    <CheckboxField v-model="form.remember" :label="$t('pages.auth.login.remember_me')" :tabindex="3" />
                </FormContent>
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton :tabindex="4" :icon="LogInIcon">
                    {{ $t('pages.auth.login.action') }}
                </FormSubmitButton>
                <div class="text-muted-foreground text-center text-sm">
                    {{ $t('pages.auth.login.no_account') }}
                    <CapitalizeText as-child>
                        <TextLink :href="route('register')" :tabindex="5">
                            {{ $t('register') }}
                        </TextLink>
                    </CapitalizeText>
                </div>
            </SectionFooter>
        </Section>
    </Form>
</template>
