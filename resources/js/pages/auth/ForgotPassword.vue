<script setup lang="ts">
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { TextLink } from '@/components/ui/custom/link';
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
    <Head :title="trans('pages.auth.forgot_password.title')" />

    <Alert class="mb-6" v-if="status" variant="primary">
        <CheckIcon class="size-4" />
        <AlertTitle>
            {{ status }}
        </AlertTitle>
    </Alert>

    <Form @submit="submit()">
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

        <div class="grid gap-2">
            <Button type="submit" :loading="form.processing">
                {{ $t('pages.auth.forgot_password.email_link') }}
            </Button>
            <div class="text-muted-foreground space-x-1 text-center text-sm">
                <span>
                    {{ $t('pages.auth.forgot_password.return_to') }}
                </span>
                <CapitalizeText>
                    <TextLink :href="route('login')">
                        {{ $t('login') }}
                    </TextLink>
                </CapitalizeText>
            </div>
        </div>
    </Form>
</template>
