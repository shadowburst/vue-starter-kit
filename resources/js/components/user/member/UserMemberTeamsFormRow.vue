<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { EnumCombobox } from '@/components/ui/custom/combobox';
import { DataTableCell, DataTableRow } from '@/components/ui/custom/data-table';
import { FormControl, FormField, FormLabel, injectFormContext } from '@/components/ui/custom/form';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { UserMemberFormData } from '@/composables';
import { PermissionName, TeamListResource } from '@/types';
import { computed } from 'vue';

type Props = {
    team: TeamListResource;
};
const props = defineProps<Props>();

const form = injectFormContext<UserMemberFormData>();

const read = computed<boolean>({
    get: () => form.team_roles.findIndex(({ team_id, role }) => team_id === props.team.id && role === 'member') > -1,
    set: (value) => {
        if (value) {
            if (!read.value) {
                form.team_roles = [
                    ...form.team_roles,
                    {
                        team_id: props.team.id,
                        role: 'member',
                    },
                ];
            }
        } else {
            form.team_roles = form.team_roles.filter(
                ({ team_id, role }) => !(team_id === props.team.id && role === 'member'),
            );
            write.value = false;
        }
    },
});
const write = computed<boolean>({
    get: () => form.team_roles.findIndex(({ team_id, role }) => team_id === props.team.id && role === 'editor') > -1,
    set: (value) => {
        if (value) {
            if (!write.value) {
                form.team_roles = [
                    ...form.team_roles,
                    {
                        team_id: props.team.id,
                        role: 'editor',
                    },
                ];
            }
            read.value = true;
        } else {
            form.team_roles = form.team_roles.filter(
                ({ team_id, role }) => !(team_id === props.team.id && role === 'editor'),
            );
        }
    },
});
const teamPermissions = computed<PermissionName[]>({
    get: () =>
        form.team_permissions.filter(({ team_id }) => team_id === props.team.id).map(({ permission }) => permission),
    set: (value) => {
        form.team_permissions = [
            ...form.team_permissions.filter(({ team_id }) => team_id !== props.team.id),
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
        <DataTableCell>
            <FormField>
                <FormLabel>
                    <FormControl>
                        <Checkbox v-model="read" />
                    </FormControl>
                    <CapitalizeText>
                        {{ $t('read') }}
                    </CapitalizeText>
                </FormLabel>
            </FormField>
        </DataTableCell>
        <DataTableCell>
            <FormField>
                <FormLabel>
                    <FormControl>
                        <Checkbox v-model="write" />
                    </FormControl>
                    <CapitalizeText>
                        {{ $t('write') }}
                    </CapitalizeText>
                </FormLabel>
            </FormField>
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
