<script setup lang="ts">
import AppInput from '@/components/input/AppInput.vue';
import MediaInput from '@/components/input/MediaInput.vue';
import DeleteProfileDialog from '@/components/settings/profile/DeleteProfileDialog.vue';
import TextLink from '@/components/TextLink.vue';
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormContent, FormControl, FormDescription, FormError, FormField, FormLabel } from '@/components/ui/form';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { useAuth, useLayout } from '@/composables';
import { SettingsLayout } from '@/layouts';
import { EditProfileSettingsProps, SharedData, UpdateProfileSettingsRequest } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { SaveIcon } from 'lucide-vue-next';

defineOptions({
    layout: useLayout(SettingsLayout, {}),
});

type Props = SharedData & EditProfileSettingsProps;
defineProps<Props>();

const auth = useAuth();

const form = useForm({
    first_name: auth.value.user.first_name,
    last_name: auth.value.user.last_name,
    email: auth.value.user.email,
    avatar: auth.value.user.avatar,
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
    <Head title="Profile settings" />

    <Form @submit="submit()">
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
                    <FormField id="avatar">
                        <FormLabel>
                            {{ $t('models.user.fields.avatar') }}
                        </FormLabel>
                        <FormControl>
                            <MediaInput
                                v-model="form.avatar"
                                v-model:error="form.errors.avatar"
                                model-type="user"
                                :model-id="auth.user.id"
                                collection="avatar"
                                type="image"
                            >
                                <UserAvatar size="lg" shape="circle" :user="{ ...auth.user, avatar: form.avatar }" />
                            </MediaInput>
                        </FormControl>
                        <FormError :message="form.errors.avatar" />
                    </FormField>
                    <FormField id="first_name" required>
                        <FormLabel>
                            {{ $t('models.user.fields.first_name') }}
                        </FormLabel>
                        <FormControl>
                            <AppInput v-model="form.first_name" autocomplete="given-name" />
                        </FormControl>
                        <FormError :message="form.errors.first_name" />
                    </FormField>
                    <FormField id="last_name" required>
                        <FormLabel>
                            {{ $t('models.user.fields.last_name') }}
                        </FormLabel>
                        <FormControl>
                            <AppInput v-model="form.last_name" autocomplete="family-name" />
                        </FormControl>
                        <FormError :message="form.errors.last_name" />
                    </FormField>
                    <FormField id="email" required>
                        <FormLabel>
                            {{ $t('models.user.fields.email') }}
                        </FormLabel>
                        <FormControl>
                            <AppInput v-model="form.email" type="email" autocomplete="email" />
                        </FormControl>
                        <FormError :message="form.errors.email" />
                        <FormDescription v-if="mustVerifyEmail">
                            Your email address is unverified.
                            <TextLink :href="route('verification.notice')">
                                Click here to resend the verification email.
                            </TextLink>
                        </FormDescription>
                    </FormField>
                </FormContent>
            </CardContent>
            <CardFooter>
                <Button type="submit" :loading="form.processing" :icon="SaveIcon">
                    <Capitalize>
                        {{ $t('save') }}
                    </Capitalize>
                </Button>
            </CardFooter>
        </Card>
    </Form>

    <Card>
        <CardHeader>
            <CardTitle class="text-destructive">
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
