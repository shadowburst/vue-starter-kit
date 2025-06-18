<script setup lang="ts">
import TeamForm from '@/components/team/TeamForm.vue';
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import {
    Section,
    SectionContent,
    SectionDescription,
    SectionFooter,
    SectionHeader,
    SectionTitle,
} from '@/components/ui/custom/section';
import { useLayout, useTeamForm } from '@/composables';
import { AppLayout } from '@/layouts';
import { TeamFormProps } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.teams.index.title'),
                href: route('teams.index'),
            },
            {
                title: trans('pages.teams.create.title'),
                href: route('teams.create'),
            },
        ],
    })),
});

defineProps<TeamFormProps>();

const form = useTeamForm();

function submit() {
    form.post(route('teams.store'));
}
</script>

<template>
    <Head :title="$t('pages.teams.create.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.teams.create.title') }}
                </SectionTitle>
                <SectionDescription>
                    {{ $t('pages.teams.create.description') }}
                </SectionDescription>
            </SectionHeader>
            <SectionContent class="sm:flex">
                <TeamForm autofocus />
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton />
            </SectionFooter>
        </Section>
    </Form>
</template>
