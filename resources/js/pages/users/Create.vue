<script setup lang="ts">
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import UserForm from '@/components/user/UserForm.vue';
import { useLayout, useUserForm } from '@/composables';
import { AppLayout } from '@/layouts';
import { UserCreateProps } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.users.index.title'),
                href: route('users.index'),
            },
            {
                title: trans('pages.users.create.title'),
                href: route('users.create'),
            },
        ],
    })),
});

defineProps<UserCreateProps>();
const form = useUserForm();

function submit() {
    form.post(route('users.store'));
}
</script>

<template>
    <Head :title="$t('pages.users.create.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.users.create.title') }}
                </SectionTitle>
            </SectionHeader>
            <SectionContent class="sm:flex">
                <UserForm />
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton />
            </SectionFooter>
        </Section>
    </Form>
</template>
