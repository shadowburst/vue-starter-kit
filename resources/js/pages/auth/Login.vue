<script setup lang="ts">
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Form,
    FormContent,
    FormControl,
    FormError,
    FormField,
    FormLabel,
    FormSubmitButton,
} from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter, SectionHeader } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { LoginProps, LoginRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { CheckIcon } from 'lucide-vue-next';

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
                    <AlertTitle>
                        {{ status }}
                    </AlertTitle>
                </Alert>
            </SectionHeader>
            <SectionContent>
                <FormContent>
                    <FormField required>
                        <FormLabel class="after:content-['']!">
                            <CapitalizeText>
                                {{ $t('models.user.fields.email') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput v-model="form.email" type="email" autofocus autocomplete="email" :tabindex="1" />
                        </FormControl>
                        <FormError :message="form.errors.email" />
                    </FormField>
                    <FormField required>
                        <div class="flex items-center justify-between">
                            <FormLabel class="after:content-['']!">
                                <CapitalizeText>
                                    {{ $t('models.user.fields.password') }}
                                </CapitalizeText>
                            </FormLabel>
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
                            <TextInput
                                v-model="form.password"
                                type="password"
                                autocomplete="current-password"
                                :tabindex="2"
                            />
                        </FormControl>
                        <FormError :message="form.errors.password" />
                    </FormField>
                    <FormField>
                        <FormLabel>
                            <FormControl>
                                <Checkbox v-model="form.remember" :tabindex="3" />
                            </FormControl>
                            <CapitalizeText>
                                {{ $t('pages.auth.login.remember_me') }}
                            </CapitalizeText>
                        </FormLabel>
                    </FormField>
                </FormContent>
            </SectionContent>
            <SectionFooter class="grid">
                <FormSubmitButton :tabindex="4">
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
