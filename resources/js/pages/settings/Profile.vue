<script setup lang="ts">
import DeleteProfileDialog from '@/components/settings/profile/DeleteProfileDialog.vue';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Form,
    FormContent,
    FormControl,
    FormDescription,
    FormError,
    FormField,
    FormLabel,
    FormSubmitButton,
} from '@/components/ui/custom/form';
import { MediaInput, TextInput } from '@/components/ui/custom/input';
import { TextLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { useAuth, useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditProfileSettingsProps, UpdateProfileSettingsRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(SettingsLayout, () => ({})),
});

defineProps<EditProfileSettingsProps>();

const { user } = useAuth();

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    phone: user.phone,
    email: user.email,
    avatar: user.avatar,
}).transform(
    (data): UpdateProfileSettingsRequest => ({
        ...data,
        avatar: data.avatar?.uuid,
    }),
);

function submit() {
    form.patch(route('settings.profile.update'));
}
</script>

<template>
    <Head :title="$t('pages.settings.profile.title')" />

    <Form :form @submit="submit()">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ $t('pages.settings.profile.information.title') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('pages.settings.profile.information.description') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <FormContent>
                    <FormField>
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
                                :model-id="user.id"
                                collection="avatar"
                                type="image"
                            >
                                <UserAvatar size="lg" shape="circle" :user="{ ...user, avatar: form.avatar }" />
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
                            <TextInput v-model="form.first_name" autocomplete="given-name" autofocus />
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
                            <TextInput v-model="form.last_name" autocomplete="family-name" />
                        </FormControl>
                        <FormError :message="form.errors.last_name" />
                    </FormField>
                    <FormField>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.phone') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput v-model="form.phone" type="tel" autocomplete="phone" />
                        </FormControl>
                        <FormError :message="form.errors.phone" />
                    </FormField>
                    <FormField required>
                        <FormLabel>
                            <CapitalizeText>
                                {{ $t('models.user.fields.email') }}
                            </CapitalizeText>
                        </FormLabel>
                        <FormControl>
                            <TextInput v-model="form.email" type="email" autocomplete="email" />
                        </FormControl>
                        <FormError :message="form.errors.email" />
                        <FormDescription v-if="mustVerifyEmail">
                            {{ $t('pages.settings.profile.information.unverified_email') }}
                            <TextLink :href="route('verification.notice')">
                                {{ $t('pages.settings.profile.information.verify_email') }}
                            </TextLink>
                        </FormDescription>
                    </FormField>
                </FormContent>
            </CardContent>
            <CardFooter>
                <FormSubmitButton />
            </CardFooter>
        </Card>
    </Form>

    <Card>
        <CardHeader>
            <CardTitle>
                {{ $t('pages.settings.profile.delete.title') }}
            </CardTitle>
            <CardDescription>
                {{ $t('pages.settings.profile.delete.description') }}
            </CardDescription>
        </CardHeader>
        <CardFooter>
            <DeleteProfileDialog />
        </CardFooter>
    </Card>
</template>
