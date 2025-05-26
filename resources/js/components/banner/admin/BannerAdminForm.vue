<script setup lang="ts">
import { FormContent, FormControl, FormError, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
</script>

<template>
    <FormContent>
        <FormField required>
            <FormLabel>
                {{ $t('models.banner.fields.name') }}
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.name" />
            </FormControl>
            <FormError :message="form.errors.name" />
        </FormField>
    </FormContent>
</template>
