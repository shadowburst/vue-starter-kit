<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Capitalize } from '@/components/typography';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ForgotPasswordProps, ForgotPasswordRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { CheckIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.forgot_password.title'),
        description: trans('pages.auth.forgot_password.description'),
    })),
});

type Props = SharedData & ForgotPasswordProps;
defineProps<Props>();

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
            <FormField id="email" required>
                <FormLabel>{{ $t('models.user.fields.email') }}</FormLabel>
                <FormControl>
                    <AppInput v-model="form.email" type="email" autocomplete="off" autofocus />
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
                <Capitalize>
                    <TextLink :href="route('login')">
                        {{ $t('login') }}
                    </TextLink>
                </Capitalize>
            </div>
        </div>
    </Form>
</template>
