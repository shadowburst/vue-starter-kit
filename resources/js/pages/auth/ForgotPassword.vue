<script setup lang="ts">
import { Alert, AlertTitle } from '@/components/ui/alert';
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
                    <FormField required>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.email') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput v-model="form.email" type="email" autocomplete="off" autofocus />
                        </FormControl>
                        <FormError :message="form.errors.email" />
                    </FormField>
                </FormContent>
            </SectionContent>
            <SectionFooter class="grid">
                <FormSubmitButton>
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
