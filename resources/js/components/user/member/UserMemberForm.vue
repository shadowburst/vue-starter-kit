<script setup lang="ts">
import { AccountSettingsForm } from '@/components/settings/account';
import { TextField } from '@/components/ui/custom/field';
import { FormContent, FormGroup, FormProps, FormSeparator, injectFormContext } from '@/components/ui/custom/form';
import { UserMemberFormData } from '@/composables';
import { UserResource } from '@/types';

type Props = FormProps & {
    user?: UserResource;
};
const props = defineProps<Props>();

const { form } = injectFormContext<UserMemberFormData>();
</script>

<template>
    <FormGroup :class="props.class">
        <AccountSettingsForm :user />
        <FormSeparator />
        <FormContent>
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
    </FormGroup>
</template>
