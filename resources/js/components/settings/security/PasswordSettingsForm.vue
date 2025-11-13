<script setup lang="ts">
import { TextField } from '@/components/ui/custom/field';
import { FormContent, injectFormContext } from '@/components/ui/custom/form';
import { PasswordSettingsFormData } from '@/composables/settings';

const { form } = injectFormContext<PasswordSettingsFormData>();
</script>

<template>
    <FormContent>
        <TextField
            v-model="form.current_password"
            :label="$t('models.user.fields.current_password')"
            :errors="form.errors.current_password"
            type="password"
            autocomplete="current-password"
            required
        />
        <TextField
            v-model="form.password"
            :label="$t('models.user.fields.password')"
            :errors="form.errors.password"
            type="password"
            autocomplete="new-password"
            required
        />
        <TextField
            v-model="form.password_confirmation"
            :label="$t('models.user.fields.password_confirmation')"
            :errors="form.errors.password_confirmation"
            type="password"
            autocomplete="new-password"
            required
        />
    </FormContent>
</template>
