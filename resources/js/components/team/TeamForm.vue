<script setup lang="ts">
import { MediaField, TextField } from '@/components/ui/custom/field';
import { FormContent, FormProps, injectFormContext } from '@/components/ui/custom/form';
import { TeamFormData } from '@/composables';
import { TeamResource } from '@/types';
import TeamLogoIcon from './TeamLogoIcon.vue';

type Props = FormProps & {
    team?: TeamResource;
};
defineProps<Props>();

const { form } = injectFormContext<TeamFormData>();
</script>

<template>
    <FormContent>
        <MediaField
            v-if="team"
            v-model="form.logo"
            :label="$t('models.team.fields.logo')"
            :errors="form.errors.logo"
            model-type="team"
            :model-id="team.id"
            collection="logo"
            type="image"
            accept="image/svg+xml"
            class="w-min"
        >
            <template #preview>
                <TeamLogoIcon class="bg-primary text-primary-foreground size-32 p-4" :media="form.logo" />
            </template>
        </MediaField>

        <TextField
            v-model="form.name"
            :label="$t('models.team.fields.name')"
            :errors="form.errors.name"
            required
            :autofocus
        />
    </FormContent>
</template>
