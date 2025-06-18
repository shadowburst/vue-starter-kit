<script setup lang="ts">
import {
    FormContent,
    FormControl,
    FormError,
    FormField,
    FormLabel,
    FormProps,
    injectFormContext,
} from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { TeamFormData } from '@/composables';

defineProps<FormProps>();

const { form } = injectFormContext<TeamFormData>();
</script>

<template>
    <FormContent>
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.team.fields.name') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.name" :autofocus />
            </FormControl>
            <FormError :message="form.errors.name" />
        </FormField>
    </FormContent>
</template>
