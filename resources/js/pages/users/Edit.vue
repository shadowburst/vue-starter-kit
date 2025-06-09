<script setup lang="ts">
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@/components/ui/custom/section';
import UserForm from '@/components/user/UserForm.vue';
import { useLayout, useUserForm } from '@/composables';
import { AppLayout } from '@/layouts';
import { UserEditProps } from '@/types';
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
                title: route().params.user,
                href: route('users.edit', { member: route().params.member }),
            },
        ],
    })),
});

const props = defineProps<UserEditProps>();

const form = useUserForm(props.user);

function submit() {
    const { user } = props;
    form.put(route('users.update', { member: user }));
}
</script>

<template>
    <Head :title="$t('pages.users.edit.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.users.edit.title') }}
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
