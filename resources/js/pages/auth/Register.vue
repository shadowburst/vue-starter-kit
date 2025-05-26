<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { TextLink } from '@/components/ui/custom/link';
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

    <Form @submit="submit()">
        <FormContent>
            <FormField required>
                <FormLabel>
                    <CapitalizeText>
                        {{ $t('models.user.fields.first_name') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.first_name" autofocus autocomplete="given-name" />
                </FormControl>
                <FormError :message="form.errors.first_name" />
            </FormField>
            <FormField required>
                <FormLabel>
                    <CapitalizeText>
                        {{ $t('models.user.fields.last_name') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.last_name" autocomplete="family-name" />
                </FormControl>
                <FormError :message="form.errors.last_name" />
            </FormField>
            <FormField required>
                <FormLabel>
                    <CapitalizeText>
                        {{ $t('models.user.fields.email') }}
                    </CapitalizeText>
                </FormLabel>
                <FormControl>
                    <TextInput v-model="form.email" type="email" autocomplete="email" />
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

        <div class="grid gap-2">
            <Button type="submit" :loading="form.processing">
                {{ $t('pages.auth.register.action') }}
            </Button>
            <div class="text-muted-foreground text-center text-sm">
                {{ $t('pages.auth.register.has_account') }}
                <CapitalizeText>
                    <TextLink :href="route('login')">
                        {{ $t('login') }}
                    </TextLink>
                </CapitalizeText>
            </div>
        </div>
    </Form>
</template>
