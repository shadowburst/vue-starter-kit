<script setup lang="ts">
import { CheckboxField, TextareaField, TextField } from '@/components/ui/custom/field';
import { FormContent, FormProps, injectFormContext } from '@/components/ui/custom/form';
import { BannerAdminFormData } from '@/composables';
import { cn } from '@/lib/utils';

const props = defineProps<FormProps>();

const { form } = injectFormContext<BannerAdminFormData>();
</script>

<template>
    <FormContent :class="cn('sm:grid-cols-2', props.class)">
        <TextField
            v-model="form.name"
            :label="$t('models.banner.fields.name')"
            :errors="form.errors.name"
            autofocus
            required
        />
        <TextField
            v-model="form.action"
            :label="$t('models.banner.fields.action')"
            :errors="form.errors.action"
            type="url"
        />
        <TextareaField
            v-model="form.message"
            :label="$t('models.banner.fields.message')"
            :errors="form.errors.message"
            class="col-span-full"
            required
            :maxlength="255"
        />
        <CheckboxField
            v-model="form.is_enabled"
            :label="$t('models.banner.fields.is_enabled')"
            :errors="form.errors.is_enabled"
        />
    </FormContent>
</template>
