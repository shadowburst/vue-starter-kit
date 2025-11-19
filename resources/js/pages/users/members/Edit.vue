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
import UserMemberForm from '@/components/user/member/UserMemberForm.vue';
import UserMemberTeamsForm from '@/components/user/member/UserMemberTeamsForm.vue';
import { useLayout, useUserMemberForm } from '@/composables';
import { AppLayout } from '@/layouts';
import type { UserMemberFormProps } from '@/types';
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
                title: route().params.member,
                href: route('users.members.edit', { member: route().params.member }),
            },
        ],
    })),
});

const props = defineProps<UserMemberFormProps>();

const form = useUserMemberForm(props.user);

function submit() {
    const { user } = props;
    form.put(route('users.members.update', { member: user! }));
}
</script>

<template>
    <Head :title="$t('pages.users.members.edit.title')" />

    <Form :form :disabled="!user?.policy?.update" @submit="submit()">
        <Section class="sm:max-w-xl">
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.users.members.edit.title') }}
                </SectionTitle>
                <SectionDescription>
                    {{ $t('pages.users.members.edit.description') }}
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
