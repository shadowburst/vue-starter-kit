<script setup lang="ts">
import { MediaField } from '@/components/media';
import { TextField } from '@/components/ui/custom/field';
import { FormContent, FormProps, injectFormContext } from '@/components/ui/custom/form';
import { TextLink } from '@/components/ui/custom/link';
import { FieldDescription } from '@/components/ui/field';
import { UserAvatar } from '@/components/user';
import { AccountSettingsFormData } from '@/composables/settings';
import { UserResource } from '@/types';

type Props = FormProps & {
    user?: UserResource;
};
const props = defineProps<Props>();

const { form } = injectFormContext<AccountSettingsFormData>();
</script>

<template>
    <FormContent :class="props.class">
        <MediaField
            v-if="user"
            v-model="form.avatar"
            :label="$t('models.user.fields.avatar')"
            model-type="user"
            :model-id="user.id"
            collection="avatar"
            type="image"
        >
            <template #preview>
                <UserAvatar size="lg" :user="{ ...user, avatar: form.avatar }" />
            </template>
        </MediaField>
        <TextField
            v-model="form.first_name"
            :label="$t('models.user.fields.first_name')"
            :errors="form.errors.first_name"
            autocomplete="given-name"
            autofocus
            required
        />
        <TextField
            v-model="form.last_name"
            :label="$t('models.user.fields.last_name')"
            :errors="form.errors.last_name"
            autocomplete="family-name"
            required
        />
        <TextField
            v-model="form.email"
            :label="$t('models.user.fields.email')"
            :errors="form.errors.email"
            type="email"
            autocomplete="email"
            required
        >
            <template #description v-if="user && !user.email_verified_at">
                <FieldDescription>
                    {{ $t('pages.settings.account.information.unverified_email') }}
                    <TextLink :href="route('verification.notice')">
                        {{ $t('pages.settings.account.information.verify_email') }}
                    </TextLink>
                </FieldDescription>
            </template>
        </TextField>
        <TextField
            v-model="form.phone"
            :label="$t('models.user.fields.phone')"
            :errors="form.errors.phone"
            type="tel"
            autocomplete="phone"
        />
    </FormContent>
</template>
