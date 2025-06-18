<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
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
import { Textarea } from '@/components/ui/textarea';
import { BannerAdminFormData } from '@/composables';

defineProps<FormProps>();

const { form } = injectFormContext<BannerAdminFormData>();
</script>

<template>
    <FormContent class="sm:grid-cols-2">
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.banner.fields.name') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.name" :autofocus />
            </FormControl>
            <FormError :message="form.errors.name" />
        </FormField>
        <FormField>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.banner.fields.action') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.action" type="url" />
            </FormControl>
            <FormError :message="form.errors.action" />
        </FormField>
        <FormField class="col-span-full" required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.banner.fields.message') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <Textarea v-model="form.message" />
            </FormControl>
            <FormError :message="form.errors.message" />
        </FormField>
        <FormField>
            <FormLabel>
                <FormControl>
                    <Checkbox v-model="form.is_enabled" />
                </FormControl>
                <CapitalizeText>
                    {{ $t('models.banner.fields.is_enabled') }}
                </CapitalizeText>
            </FormLabel>
            <FormError :message="form.errors.is_enabled" />
        </FormField>
    </FormContent>
</template>
