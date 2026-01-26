<script setup lang="ts">
import TeamForm from '@/components/team/TeamForm.vue';
import { Form, FormSubmitButton } from '@/components/ui/custom/form';
import { TextLink } from '@/components/ui/custom/link';
import { Section, SectionContent, SectionFooter } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useLayout, useTeamForm } from '@/composables';
import { AuthLayout } from '@/layouts';
import TeamFirstController from '@/wayfinder/App/Http/Controllers/Team/TeamFirstController';
import AuthenticatedSessionController from '@/wayfinder/Laravel/Fortify/Http/Controllers/AuthenticatedSessionController';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

defineOptions({
    layout: useLayout(AuthLayout, () => ({
        title: trans('pages.teams.first.create.title'),
        description: trans('pages.teams.first.create.description'),
    })),
});

const form = useTeamForm(TeamFirstController.store());
</script>

<template>
    <Head :title="$t('pages.teams.first.create.title')" />

    <Form :form @submit="form.submit()">
        <Section>
            <SectionContent>
                <TeamForm autofocus />
            </SectionContent>
            <SectionFooter>
                <FormSubmitButton />

                <div class="text-muted-foreground space-x-1 text-center text-sm">
                    {{ $t('pages.teams.first.required.not_you') }}
                    <CapitalizeText as-child>
                        <TextLink :href="AuthenticatedSessionController.destroy()">
                            {{ $t('logout') }}
                        </TextLink>
                    </CapitalizeText>
                </div>
            </SectionFooter>
        </Section>
    </Form>
</template>
