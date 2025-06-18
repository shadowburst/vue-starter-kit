<script setup lang="ts">
import TeamForm from '@/components/team/TeamForm.vue';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { useLayout, useTeamForm } from '@/composables';
import { TeamsFormLayout } from '@/layouts';
import { TeamFormProps } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(TeamsFormLayout, () => ({
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
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ $t('pages.teams.edit.title') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('pages.teams.edit.description') }}
                </CardDescription>
            </CardHeader>
            <CardContent class="sm:flex">
                <TeamForm autofocus />
            </CardContent>
            <CardFooter>
                <FormSubmitButton />
            </CardFooter>
        </Card>
    </Form>
</template>
