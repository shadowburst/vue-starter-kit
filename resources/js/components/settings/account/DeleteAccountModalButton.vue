<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import {
    SmartModal,
    SmartModalClose,
    SmartModalContent,
    SmartModalDescription,
    SmartModalFooter,
    SmartModalHeader,
    SmartModalTitle,
    SmartModalTrigger,
} from '@/components/ui/custom/smart-modal';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { ConfirmPasswordRequest } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { whenever } from '@vueuse/core';
import { ref, useTemplateRef } from 'vue';

const passwordField = useTemplateRef<InstanceType<typeof TextInput>>('password');

const form = useForm<ConfirmPasswordRequest>({
    password: '',
});

const open = ref(false);
whenever(open, () => {
    form.reset();
    form.clearErrors();
});

function submit() {
    form.delete(route('settings.account.destroy'), {
        onError: () => {
            passwordField.value?.$el?.focus();
        },
        onFinish: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <SmartModal v-model:open="open">
        <SmartModalTrigger as-child>
            <Button variant="destructive">
                <CapitalizeText>
                    {{ $t('components.settings.account.delete_modal.action') }}
                </CapitalizeText>
            </Button>
        </SmartModalTrigger>
        <SmartModalContent as-child>
            <Form :form @submit="submit()">
                <SmartModalHeader>
                    <SmartModalTitle>
                        {{ $t('components.settings.account.delete_modal.title') }}
                    </SmartModalTitle>
                    <SmartModalDescription>
                        {{ $t('components.settings.account.delete_modal.description') }}
                    </SmartModalDescription>
                </SmartModalHeader>
                <FormContent>
                    <TextField
                        v-model="form.password"
                        ref="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        :label="$t('models.user.fields.password')"
                        :description="$t('components.settings.account.delete_modal.password_description')"
                        :errors="form.errors.password"
                    />
                </FormContent>
                <SmartModalFooter>
                    <SmartModalClose as-child @click="form.reset()">
                        <Button variant="ghost">
                            <CapitalizeText>
                                {{ $t('cancel') }}
                            </CapitalizeText>
                        </Button>
                    </SmartModalClose>
                    <FormSubmitButton :disabled="!form.password" variant="destructive" :icon="false">
                        {{ $t('components.settings.account.delete_modal.action') }}
                    </FormSubmitButton>
                </SmartModalFooter>
            </Form>
        </SmartModalContent>
    </SmartModal>
</template>
