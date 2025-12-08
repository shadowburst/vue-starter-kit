<script setup lang="ts">
import { AccountSettingsForm, DeleteAccountModalButton } from '@/components/settings/account';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormActions, FormSubmitButton } from '@/components/ui/custom/form';
import { Item, ItemActions, ItemContent, ItemDescription, ItemTitle } from '@/components/ui/item';
import { useAuth, useLayout } from '@/composables';
import { useAccountSettingsForm } from '@/composables/settings';
import { SettingsLayout } from '@/layouts';
import { EditAccountSettingsProps } from '@/types';
import { Head } from '@inertiajs/vue3';

defineOptions({
    layout: useLayout(SettingsLayout, () => ({})),
});

defineProps<EditAccountSettingsProps>();

const { user } = useAuth();

const form = useAccountSettingsForm(user.value);

function submit() {
    form.patch(route('settings.account.update'));
}
</script>

<template>
    <Head :title="$t('pages.settings.account.title')" />

    <Form :form @submit="submit()">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ $t('pages.settings.account.information.title') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('pages.settings.account.information.description') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <AccountSettingsForm :user />
            </CardContent>
            <CardFooter>
                <FormActions>
                    <FormSubmitButton />
                </FormActions>
            </CardFooter>
        </Card>
    </Form>

    <Item variant="outline">
        <ItemContent>
            <ItemTitle>
                {{ $t('pages.settings.account.delete.title') }}
            </ItemTitle>
            <ItemDescription>
                {{ $t('pages.settings.account.delete.description') }}
            </ItemDescription>
        </ItemContent>
        <ItemActions>
            <DeleteAccountModalButton />
        </ItemActions>
    </Item>
</template>
