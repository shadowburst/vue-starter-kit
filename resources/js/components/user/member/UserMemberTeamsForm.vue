<script setup lang="ts">
import {
    DataTable,
    DataTableBody,
    DataTableContent,
    DataTableHead,
    DataTableHeader,
    DataTableRow,
} from '@/components/ui/custom/data-table';
import { FormContent } from '@/components/ui/custom/form';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { usePageProp } from '@/composables';
import type { TeamResource } from '@/types';
import UserMemberTeamsFormRow from './UserMemberTeamsFormRow.vue';

const teams = usePageProp<TeamResource[]>('teams', []);
</script>

<template>
    <FormContent>
        <DataTable v-slot="{ rows }" :data="teams">
            <DataTableContent tab="table">
                <DataTableHeader>
                    <DataTableRow>
                        <DataTableHead>
                            <CapitalizeText>
                                {{ $t('models.team.name.many') }}
                            </CapitalizeText>
                        </DataTableHead>
                        <DataTableHead colspan="2">
                            <CapitalizeText>
                                {{ $t('models.role.name.many') }}
                            </CapitalizeText>
                        </DataTableHead>
                        <DataTableHead>
                            <CapitalizeText>
                                {{ $t('models.permission.name.many') }}
                            </CapitalizeText>
                        </DataTableHead>
                    </DataTableRow>
                </DataTableHeader>
                <DataTableBody>
                    <UserMemberTeamsFormRow v-for="team in rows" :key="team.id" :team />
                </DataTableBody>
            </DataTableContent>
        </DataTable>
    </FormContent>
</template>
