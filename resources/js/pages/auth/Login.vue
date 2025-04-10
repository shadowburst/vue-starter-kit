<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Capitalize } from '@/components/typography';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { LoginProps, LoginRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { CheckIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.login.title'),
        description: trans('pages.auth.login.description'),
    })),
});

type Props = SharedData & LoginProps;
defineProps<Props>();

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
            <FormField id="email" required>
                <FormLabel class="after:content-['']!">
                    {{ $t('models.user.fields.email') }}
                </FormLabel>
                <FormControl>
                    <AppInput v-model="form.email" type="email" autofocus autocomplete="email" />
                </FormControl>
                <FormError :message="form.errors.email" />
            </FormField>
            <FormField id="password" required>
                <div class="flex items-center justify-between">
                    <FormLabel class="after:content-['']!">
                        {{ $t('models.user.fields.password') }}
                    </FormLabel>
                    <TextLink class="text-sm" v-if="canResetPassword" :href="route('password.request')">
                        {{ $t('pages.auth.login.forgot_password') }}
                    </TextLink>
                </div>
                <FormControl>
                    <AppInput v-model="form.password" type="password" autocomplete="current-password" />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>

            <FormField id="remember">
                <FormLabel class="inline-flex gap-2">
                    <FormControl>
                        <Checkbox v-model="form.remember" />
                    </FormControl>
                    <span>
                        {{ $t('pages.auth.login.remember_me') }}
                    </span>
                </FormLabel>
            </FormField>
        </FormContent>

        <div class="grid gap-2">
            <Button type="submit" :loading="form.processing"> Log in </Button>
            <div class="text-muted-foreground text-center text-sm">
                {{ $t('pages.auth.login.no_account') }}
                <Capitalize>
                    <TextLink :href="route('register')">
                        {{ $t('register') }}
                    </TextLink>
                </Capitalize>
            </div>
        </div>
    </Form>
</template>
