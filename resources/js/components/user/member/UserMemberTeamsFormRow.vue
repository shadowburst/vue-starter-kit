<script setup lang="ts">
import { EnumCombobox } from '@/components/ui/custom/combobox';
import { DataTableCell, DataTableRow } from '@/components/ui/custom/data-table';
import { CheckboxField } from '@/components/ui/custom/field';
import { FormControl, FormField, injectFormContext } from '@/components/ui/custom/form';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { UserMemberFormData } from '@/composables';
import { PermissionName, type TeamResource } from '@/types';
import { computed } from 'vue';

type Props = {
    team: TeamResource;
};
const props = defineProps<Props>();

const { form } = injectFormContext<UserMemberFormData>();

const read = computed<boolean>({
    get: () =>
        form.value.team_roles.findIndex(({ team_id, role }) => team_id === props.team.id && role === 'member') > -1,
    set: (value) => {
        if (value) {
            if (!read.value) {
                form.value.team_roles = [
                    ...form.value.team_roles,
                    {
                        team_id: props.team.id,
                        role: 'member',
                    },
                ];
            }
        } else {
            form.value.team_roles = form.value.team_roles.filter(
                ({ team_id, role }) => !(team_id === props.team.id && role === 'member'),
            );
            write.value = false;
        }
    },
});
const write = computed<boolean>({
    get: () =>
        form.value.team_roles.findIndex(({ team_id, role }) => team_id === props.team.id && role === 'editor') > -1,
    set: (value) => {
        if (value) {
            if (!write.value) {
                form.value.team_roles = [
                    ...form.value.team_roles,
                    {
                        team_id: props.team.id,
                        role: 'editor',
                    },
                ];
            }
            read.value = true;
        } else {
            form.value.team_roles = form.value.team_roles.filter(
                ({ team_id, role }) => !(team_id === props.team.id && role === 'editor'),
            );
        }
    },
});
const teamPermissions = computed<PermissionName[]>({
    get: () =>
        form.value.team_permissions
            .filter(({ team_id }) => team_id === props.team.id)
            .map(({ permission }) => permission),
    set: (value) => {
        form.value.team_permissions = [
            ...form.value.team_permissions.filter(({ team_id }) => team_id !== props.team.id),
            ...value.map((permission) => ({
                team_id: props.team.id,
                permission,
            })),
        ];
    },
});
</script>

<template>
    <DataTableRow :item="team">
        <DataTableCell class="sm:min-w-40">
            <CapitalizeText>
                {{ team.name }}
            </CapitalizeText>
        </DataTableCell>
        <DataTableCell class="p-2!">
            <CheckboxField v-model="read" :label="$t('read')" />
        </DataTableCell>
        <DataTableCell class="p-2!">
            <CheckboxField v-model="write" :label="$t('write')" />
        </DataTableCell>
        <DataTableCell>
            <FormField>
                <FormControl>
                    <EnumCombobox v-model="teamPermissions" multiple data="permissions" />
                </FormControl>
            </FormField>
        </DataTableCell>
    </DataTableRow>
</template>
