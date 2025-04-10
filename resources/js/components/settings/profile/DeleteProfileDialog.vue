<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Form, FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/form';
import {
    ResponsiveDialog,
    ResponsiveDialogClose,
    ResponsiveDialogContent,
    ResponsiveDialogDescription,
    ResponsiveDialogFooter,
    ResponsiveDialogHeader,
    ResponsiveDialogTitle,
    ResponsiveDialogTrigger,
} from '@/components/ui/responsive-dialog';
import { ConfirmPasswordRequest } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { useTemplateRef } from 'vue';

const passwordField = useTemplateRef<InstanceType<typeof Input>>('password');

const form = useForm<ConfirmPasswordRequest>({
    password: '',
});

function submit() {
    form.delete(route('settings.profile.destroy'), {
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
    <ResponsiveDialog>
        <ResponsiveDialogTrigger as-child>
            <Button type="submit" variant="destructive">
                <Capitalize>
                    {{ $t('components.settings.profile.delete_dialog.action') }}
                </Capitalize>
            </Button>
        </ResponsiveDialogTrigger>
        <ResponsiveDialogContent>
            <Form class="max-sm:gap-0" @submit="submit()">
                <ResponsiveDialogHeader>
                    <ResponsiveDialogTitle>
                        {{ $t('components.settings.profile.delete_dialog.title') }}
                    </ResponsiveDialogTitle>
                    <ResponsiveDialogDescription>
                        {{ $t('components.settings.profile.delete_dialog.description') }}
                    </ResponsiveDialogDescription>
                </ResponsiveDialogHeader>
                <FormContent class="max-sm:px-4">
                    <FormField id="password" required>
                        <FormLabel>Password</FormLabel>
                        <FormControl>
                            <AppInput
                                v-model="form.password"
                                ref="password"
                                type="password"
                                autocomplete="current-password"
                            />
                        </FormControl>
                        <FormError :message="form.errors.password" />
                    </FormField>
                </FormContent>
                <ResponsiveDialogFooter>
                    <ResponsiveDialogClose as-child @click="form.reset()">
                        <Button variant="ghost">
                            <Capitalize>
                                {{ $t('cancel') }}
                            </Capitalize>
                        </Button>
                    </ResponsiveDialogClose>
                    <Button type="submit" variant="destructive" :disabled="!form.password">
                        <Capitalize>
                            {{ $t('components.settings.profile.delete_dialog.action') }}
                        </Capitalize>
                    </Button>
                </ResponsiveDialogFooter>
            </Form>
        </ResponsiveDialogContent>
    </ResponsiveDialog>
</template>
