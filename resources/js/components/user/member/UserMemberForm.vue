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
import { MediaInput, TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { UserMemberFormData } from '@/composables';

defineProps<FormProps>();

const { form } = injectFormContext<UserMemberFormData>();
</script>

<template>
    <FormContent class="sm:grid-cols-2">
        <FormField class="col-span-full" v-if="form.id">
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.avatar') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <MediaInput
                    v-model="form.avatar"
                    v-model:error="form.errors.avatar"
                    model-type="user"
                    :model-id="form.id"
                    collection="avatar"
                    type="image"
                >
                    <UserAvatar size="lg" shape="circle" :user="form" />
                </MediaInput>
            </FormControl>
            <FormError :message="form.errors.avatar" />
        </FormField>
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.user.fields.first_name') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.first_name" :autofocus />
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
