<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { TextField } from '@/components/ui/custom/field';
import { Form, FormContent, FormSubmitButton } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer';
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
    <Drawer v-model:open="open">
        <DrawerTrigger as-child>
            <Button variant="destructive">
                <CapitalizeText>
                    {{ $t('components.settings.account.delete_dialog.action') }}
                </CapitalizeText>
            </Button>
        </DrawerTrigger>
        <DrawerContent>
            <Form :form class="mx-auto sm:max-w-fit" @submit="submit()">
                <DrawerHeader>
                    <DrawerTitle>
                        {{ $t('components.settings.account.delete_dialog.title') }}
                    </DrawerTitle>
                    <DrawerDescription>
                        {{ $t('components.settings.account.delete_dialog.description') }}
                    </DrawerDescription>
                </DrawerHeader>
                <FormContent class="p-4">
                    <TextField
                        v-model="form.password"
                        ref="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        :label="$t('models.user.fields.password')"
                        :description="$t('components.settings.account.delete_dialog.password_description')"
                        :errors="form.errors.password"
                    />
                </FormContent>
                <DrawerFooter>
                    <FormSubmitButton :disabled="!form.password" variant="destructive">
                        {{ $t('components.settings.account.delete_dialog.action') }}
                    </FormSubmitButton>
                    <DrawerClose as-child @click="form.reset()">
                        <Button variant="ghost">
                            <CapitalizeText>
                                {{ $t('cancel') }}
                            </CapitalizeText>
                        </Button>
                    </DrawerClose>
                </DrawerFooter>
            </Form>
        </DrawerContent>
    </Drawer>
</template>
