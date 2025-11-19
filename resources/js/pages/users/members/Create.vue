<script setup lang="ts">
import { Form, FormActions, FormGroup, FormSubmitButton } from '@/components/ui/custom/form';
import {
    Section,
    SectionContent,
    SectionDescription,
    SectionFooter,
    SectionHeader,
    SectionTitle,
} from '@/components/ui/custom/section';
import { UserMemberForm, UserMemberTeamsForm } from '@/components/user/member';
import { useLayout, useUserMemberForm } from '@/composables';
import { AppLayout } from '@/layouts';
import { UserMemberFormProps } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.users.members.index.title'),
                href: route('users.members.index'),
            },
            {
                title: trans('pages.users.members.create.title'),
                href: route('users.members.create'),
            },
        ],
    })),
});

defineProps<UserMemberFormProps>();

const form = useUserMemberForm();

function submit() {
    form.post(route('users.members.store'));
}
</script>

<template>
    <Head :title="$t('pages.users.members.create.title')" />

    <Form :form @submit="submit()">
        <Section class="sm:max-w-xl">
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.users.members.create.title') }}
                </SectionTitle>
                <SectionDescription>
                    {{ $t('pages.users.members.create.description') }}
                </SectionDescription>
            </SectionHeader>
            <SectionContent>
                <FormGroup>
                    <UserMemberForm />
                    <UserMemberTeamsForm />
                </FormGroup>
            </SectionContent>
            <SectionFooter>
                <FormActions>
                    <FormSubmitButton />
                </FormActions>
            </SectionFooter>
        </Section>
    </Form>
</template>
