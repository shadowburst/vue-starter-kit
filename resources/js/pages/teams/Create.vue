<script setup lang="ts">
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import UserForm from '@/components/user/UserForm.vue';
import { useLayout, useUserForm } from '@/composables';
import { AdminLayout } from '@/layouts';
import { UserCreateProps } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AdminLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.users.admin.index.title'),
                href: route('admin.users.index'),
            },
            {
                title: trans('pages.users.admin.create.title'),
                href: route('admin.users.create'),
            },
        ],
    })),
});

defineProps<UserCreateProps>();
const form = useUserForm();

function submit() {
    form.post(route('admin.users.store'));
}
</script>

<template>
    <Head :title="$t('pages.users.admin.create.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.users.admin.create.title') }}
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
