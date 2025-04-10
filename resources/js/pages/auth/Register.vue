<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { RegisterProps, RegisterRequest, SharedData } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.register.title'),
        description: trans('pages.auth.register.description'),
    })),
});

type Props = SharedData & RegisterProps;
defineProps<Props>();

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
            <FormField id="first_name" required>
                <FormLabel>
                    {{ $t('models.user.fields.first_name') }}
                </FormLabel>
                <FormControl>
                    <AppInput v-model="form.first_name" autofocus autocomplete="given-name" />
                </FormControl>
                <FormError :message="form.errors.first_name" />
            </FormField>
            <FormField id="last_name" required>
                <FormLabel>
                    {{ $t('models.user.fields.last_name') }}
                </FormLabel>
                <FormControl>
                    <AppInput v-model="form.last_name" autocomplete="family-name" />
                </FormControl>
                <FormError :message="form.errors.last_name" />
            </FormField>
            <FormField id="email" required>
                <FormLabel>
                    {{ $t('models.user.fields.email') }}
                </FormLabel>
                <FormControl>
                    <AppInput v-model="form.email" type="email" autocomplete="email" />
                </FormControl>
                <FormError :message="form.errors.email" />
            </FormField>
            <FormField id="password" required>
                <FormLabel>
                    {{ $t('models.user.fields.password') }}
                </FormLabel>
                <FormControl>
                    <AppInput v-model="form.password" type="password" autocomplete="new-password" />
                </FormControl>
                <FormError :message="form.errors.password" />
            </FormField>
            <FormField id="password_confirmation" required>
                <FormLabel>
                    {{ $t('models.user.fields.password_confirmation') }}
                </FormLabel>
                <FormControl>
                    <AppInput v-model="form.password_confirmation" type="password" autocomplete="new-password" />
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
                <Capitalize>
                    <TextLink :href="route('login')">
                        {{ $t('login') }}
                    </TextLink>
                </Capitalize>
            </div>
        </div>
    </Form>
</template>
