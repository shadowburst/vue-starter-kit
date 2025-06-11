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
                title: route().params.team,
                href: route('teams.edit', { team: route().params.team }),
            },
        ],
    })),
});

const props = defineProps<TeamFormProps>();

const form = useTeamForm(props.team);

function submit() {
    form.put(route('teams.update', { team: props.team! }));
}
</script>

<template>
    <Head :title="$t('pages.teams.edit.title')" />

    <Form :form @submit="submit()">
        <Section>
            <SectionHeader>
                <SectionTitle>
                    {{ $t('pages.teams.edit.title') }}
                </SectionTitle>
                <SectionDescription>
                    {{ $t('pages.teams.edit.description') }}
                </SectionDescription>
            </SectionHeader>
            <SectionContent class="sm:flex">
                <TeamForm />
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton />
            </SectionFooter>
        </Section>
    </Form>
</template>
