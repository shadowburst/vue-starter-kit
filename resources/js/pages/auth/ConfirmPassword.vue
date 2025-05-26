<script setup lang="ts">
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
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout } from '@/composables';
import { AuthLayout } from '@/layouts';
import { ConfirmPasswordProps, ConfirmPasswordRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.auth.confirm_password.title'),
        description: trans('pages.auth.confirm_password.description'),
    })),
});

defineProps<ConfirmPasswordProps>();

const form = useForm<ConfirmPasswordRequest>({
    password: '',
});

function submit() {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head :title="trans('pages.auth.confirm_password.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionContent>
                <FormContent>
                    <FormField required>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.password') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput
                                v-model="form.password"
                                type="password"
                                autocomplete="current-password"
                                autofocus
                            />
                        </FormControl>
                        <FormError :message="form.errors.password" />
                    </FormField>
                </FormContent>
            </SectionContent>
            <SectionFooter class="grid">
                <FormSubmitButton>
                    {{ $t('pages.auth.confirm_password.action') }}
                </FormSubmitButton>
            </SectionFooter>
        </Section>
    </Form>
</template>
