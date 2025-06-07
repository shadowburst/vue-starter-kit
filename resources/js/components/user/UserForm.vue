<script setup lang="ts">
import {
    FormContent,
    FormControl,
    FormError,
    FormField,
    FormLabel,
    injectFormContext,
} from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { UserFormData } from '@/composables';

const form = injectFormContext<UserFormData>();
</script>

<template>
    <FormContent class="sm:grid-cols-2">
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.first_name') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.first_name" />
            </FormControl>
            <FormError :message="form.errors.first_name" />
        </FormField>
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.last_name') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.last_name" />
            </FormControl>
            <FormError :message="form.errors.last_name" />
        </FormField>
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.email') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.email" type="email" />
            </FormControl>
            <FormError :message="form.errors.email" />
        </FormField>
        <FormField>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.phone') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.phone" type="tel" />
            </FormControl>
            <FormError :message="form.errors.phone" />
        </FormField>
        <FormField>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.password') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.password" type="password" />
            </FormControl>
            <FormError :message="form.errors.password" />
        </FormField>
        <FormField>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.password_confirmation') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.password_confirmation" type="password" />
            </FormControl>
            <FormError :message="form.errors.password_confirmation" />
        </FormField>
    </FormContent>
</template>
