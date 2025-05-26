<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
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

    <Form @submit="submit()">
        <FormContent>
            <FormField required>
                <FormLabel>
                    <CapitalizeText>
                        {{ $t('models.user.fields.email') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.email" type="email" autocomplete="email" readonly />
                </FormControl>
                <FormError :message="form.errors.email" />
            </FormField>
            <FormField required>
                <FormLabel>
                    <CapitalizeText>
                        {{ $t('models.user.fields.password') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.password" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>
            <FormField required>
                <FormLabel>
                    <CapitalizeText>
                        {{ $t('models.user.fields.password_confirmation') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.password_confirmation" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password_confirmation" />
            </FormField>
        </FormContent>

        <Button type="submit" :loading="form.processing">
            {{ $t('pages.auth.reset_password.action') }}
        </Button>
    </Form>
</template>
