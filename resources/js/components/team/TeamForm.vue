<script setup lang="ts">
import {
    FormContent,
    FormControl,
    FormError,
    FormField,
    FormLabel,
    FormProps,
    injectFormContext,
} from '@/components/ui/custom/form';
import { MediaInput, TextInput } from '@/components/ui/custom/input';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { TeamFormData } from '@/composables';
import { TeamFormResource } from '@/types';
import TeamLogoIcon from './TeamLogoIcon.vue';

type Props = FormProps & {
    team?: TeamFormResource;
};
defineProps<Props>();

const { form } = injectFormContext<TeamFormData>();
</script>

<template>
    <FormContent>
        <FormField v-if="team">
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.team.fields.logo') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <MediaInput
                    v-model="form.logo"
                    v-model:error="form.errors.logo"
                    model-type="team"
                    :model-id="team.id"
                    collection="logo"
                    type="image"
                    accept="image/svg+xml"
                >
                    <TeamLogoIcon class="bg-primary text-primary-foreground p-4" :media="form.logo" size="lg" />
                </MediaInput>
            </FormControl>
            <FormError :message="form.errors.logo" />
        </FormField>
        <FormField required>
            <FormLabel>
                <CapitalizeText>
                    {{ $t('models.team.fields.name') }}
                </CapitalizeText>
            </FormLabel>
            <FormControl>
                <TextInput v-model="form.name" :autofocus />
            </FormControl>
            <FormError :message="form.errors.name" />
        </FormField>
    </FormContent>
</template>
