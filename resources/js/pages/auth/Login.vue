<script setup lang="ts">
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { TextLink } from '@/components/ui/custom/link';
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

    <Alert class="mb-6" v-if="status" variant="primary">
        <CheckIcon class="size-4" />
        <AlertTitle>
            {{ status }}
        </AlertTitle>
    </Alert>

    <Form @submit="submit()">
        <FormContent>
            <FormField required>
                <FormLabel class="after:content-['']!">
                    <CapitalizeText>
                        {{ $t('models.user.fields.email') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.email" type="email" autofocus autocomplete="email" />
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
                    <TextLink class="text-sm" v-if="canResetPassword" :href="route('password.request')">
                        {{ $t('pages.auth.login.forgot_password') }}
                    </TextLink>
                </div>
                <FormControl>
                    <TextInput v-model="form.password" type="password" autocomplete="current-password" />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>

            <FormField>
                <FormLabel class="inline-flex gap-2">
                    <FormControl>
                        <Checkbox v-model="form.remember" />
                    </FormControl>
                    <CapitalizeText>
                        {{ $t('pages.auth.login.remember_me') }}
                    </CapitalizeText>
                </FormLabel>
            </FormField>
        </FormContent>

        <div class="grid gap-2">
            <Button type="submit" :loading="form.processing">
                <CapitalizeText>
                    {{ $t('pages.auth.login.action') }}
                </CapitalizeText>
            </Button>
            <div class="text-muted-foreground text-center text-sm">
                {{ $t('pages.auth.login.no_account') }}
                <CapitalizeText>
                    <TextLink :href="route('register')">
                        {{ $t('register') }}
                    </TextLink>
                </CapitalizeText>
            </div>
        </div>
    </Form>
</template>
