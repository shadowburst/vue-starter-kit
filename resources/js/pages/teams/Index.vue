<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { EnumCombobox } from '@/components/ui/custom/combobox';
import {
    DataTable,
    DataTableBody,
    DataTableCell,
    DataTableContent,
    DataTableHead,
    DataTableHeadActions,
    DataTableHeader,
    DataTablePagination,
    DataTableRow,
    DataTableRowAction,
    DataTableRowActions,
    DataTableRowCheckbox,
    DataTableRowsAction,
    DataTableRowsActions,
    DataTableRowsCheckbox,
    DataTableSortableHead,
} from '@/components/ui/custom/data-table';
import { FiltersSheet, FiltersSheetContent, FiltersSheetTrigger } from '@/components/ui/custom/filters';
import { FormContent, FormControl, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { InertiaLink } from '@/components/ui/custom/link';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useAlert, useFilters, useFormatter, useLayout } from '@/composables';
import { AppLayout } from '@/layouts';
import { type TeamIndexProps, type TeamIndexRequest, type TeamIndexResource, type TeamOneOrManyRequest } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { trans, transChoice } from 'laravel-vue-i18n';
import { ArchiveIcon, ArchiveRestoreIcon, CirclePlusIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';
import { ref } from 'vue';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.teams.index.title'),
                href: route('teams.index'),
            },
        ],
    })),
});

const props = defineProps<TeamIndexProps>();

const alert = useAlert();

const selectedRows = ref<TeamIndexResource[]>([]);
const rowsActions: DataTableRowsAction<TeamIndexResource>[] = [
    {
        label: trans('trash'),
        icon: ArchiveIcon,
        disabled: (items) => items.some((team) => !team.can_trash),
        callback: (items) =>
            alert({
                variant: 'warning',
                description: transChoice('messages.teams.trash.confirm', items.length),
                callback: () =>
                    router.delete<TeamOneOrManyRequest>(route('teams.trash'), {
                        data: { ids: items.map(({ id }) => id) },
                        only: ['teams'],
                        onSuccess: () => {
                            selectedRows.value = [];
                        },
                    }),
            }),
    },
    {
        label: trans('restore'),
        icon: ArchiveRestoreIcon,
        disabled: (items) => items.some((team) => !team.can_restore),
        callback: (items) =>
            alert({
                variant: 'success',
                description: transChoice('messages.teams.restore.confirm', items.length),
                callback: () =>
                    router.patch<TeamOneOrManyRequest>(
                        route('teams.restore'),
                        { ids: items.map(({ id }) => id) },
                        {
                            only: ['teams'],
                            onSuccess: () => {
                                selectedRows.value = [];
                            },
                        },
                    ),
            }),
    },
    {
        label: trans('delete'),
        icon: Trash2Icon,
        disabled: (items) => items.some((team) => !team.can_delete),
        callback: (items) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.teams.delete.confirm', items.length),
                callback: () =>
                    router.delete<TeamOneOrManyRequest>(route('teams.delete'), {
                        data: { ids: items.map(({ id }) => id) },
                        only: ['teams'],
                        onSuccess: () => {
                            selectedRows.value = [];
                        },
                    }),
            }),
    },
];
const rowActions: DataTableRowAction<TeamIndexResource>[] = [
    {
        type: 'href',
        label: trans('edit'),
        icon: PencilIcon,
        href: (team) => route('teams.edit', { team }),
    },
    {
        type: 'callback',
        label: trans('trash'),
        icon: ArchiveIcon,
        disabled: (team) => !team.can_trash,
        callback: (team) =>
            alert({
                variant: 'warning',
                description: transChoice('messages.teams.trash.confirm', 1),
                callback: () =>
                    router.delete<TeamOneOrManyRequest>(route('teams.trash', { team }), {
                        only: ['teams'],
                    }),
            }),
    },
    {
        type: 'callback',
        label: trans('restore'),
        icon: ArchiveRestoreIcon,
        disabled: (team) => !team.can_restore,
        callback: (team) =>
            alert({
                variant: 'success',
                description: transChoice('messages.teams.restore.confirm', 1),
                callback: () =>
                    router.patch<TeamOneOrManyRequest>(route('teams.restore', { team }), undefined, {
                        only: ['teams'],
                    }),
            }),
    },
    {
        type: 'callback',
        label: trans('delete'),
        icon: Trash2Icon,
        disabled: (team) => !team.can_delete,
        callback: (team) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.teams.delete.confirm', 1),
                callback: () =>
                    router.delete<TeamOneOrManyRequest>(route('teams.delete', { team }), {
                        only: ['teams'],
                    }),
            }),
    },
];

const filters = useFilters<TeamIndexRequest>(
    route('teams.index'),
    {
        q: props.request.q ?? '',
        page: props.request.page ?? props.teams?.meta.current_page,
        per_page: props.request.per_page ?? props.teams?.meta.per_page,
        sort_by: props.request.sort_by,
        sort_direction: props.request.sort_direction,
        trashed: props.request.trashed,
    },
    {
        only: ['teams'],
        immediate: true,
        debounceReload(keys) {
            return !keys.includes('page') && !keys.includes('per_page');
        },
        onReload(keys) {
            if (!keys.includes('page')) {
                filters.page = 1;
            }
        },
    },
);

const format = useFormatter();
</script>

<template>
    <Head :title="$t('pages.teams.index.title')" />

    <Section>
        <SectionContent>
            <DataTable
                v-slot="{ rows }"
                v-model:selected-rows="selectedRows"
                v-model:sort-by="filters.sort_by"
                v-model:sort-direction="filters.sort_direction"
                :data="teams"
                :rows-actions
                :row-actions
            >
                <FormContent class="flex items-center">
                    <TextInput v-model="filters.q" type="search" />
                    <FiltersSheet
                        :filters
                        :omit="['q', 'page', 'per_page', 'sort_by', 'sort_direction']"
                        :data="['trashed_filters']"
                    >
                        <FiltersSheetTrigger />
                        <FiltersSheetContent>
                            <FormField>
                                <FormLabel>
                                    <CapitalizeText>
                                        {{ $t('trashed') }}
                                    </CapitalizeText>
                                </FormLabel>
                                <FormControl>
                                    <EnumCombobox v-model="filters.trashed" data="trashed_filters" />
                                </FormControl>
                            </FormField>
                        </FiltersSheetContent>
                    </FiltersSheet>
                </FormContent>
                <FormContent class="flex items-center justify-between">
                    <DataTableRowsActions />
                    <Button as-child>
                        <InertiaLink :href="route('teams.create')">
                            <CirclePlusIcon />
                            <CapitalizeText class="max-sm:hidden">
                                {{ $t('pages.teams.create.title') }}
                            </CapitalizeText>
                        </InertiaLink>
                    </Button>
                </FormContent>
                <DataTableContent tab="table">
                    <DataTableHeader>
                        <DataTableRow>
                            <DataTableHead>
                                <DataTableRowsCheckbox />
                            </DataTableHead>
                            <DataTableSortableHead value="name">
                                {{ $t('models.team.fields.name') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead v-if="filters.trashed" value="deleted_at">
                                {{ $t('models.team.fields.deleted_at') }}
                            </DataTableSortableHead>
                            <DataTableHead>
                                <DataTableHeadActions />
                            </DataTableHead>
                        </DataTableRow>
                    </DataTableHeader>
                    <DataTableBody>
                        <DataTableRow
                            v-for="team in rows"
                            :key="team.id"
                            :item="team"
                            :class="{ 'bg-destructive/5': team.deleted_at }"
                        >
                            <DataTableCell>
                                <DataTableRowCheckbox />
                            </DataTableCell>
                            <DataTableCell>
                                {{ team.name }}
                            </DataTableCell>
                            <DataTableCell v-if="filters.trashed">
                                <Badge v-if="team.deleted_at" variant="destructive">
                                    {{ format.date(team.deleted_at) }}
                                </Badge>
                            </DataTableCell>
                            <DataTableCell>
                                <DataTableRowActions />
                            </DataTableCell>
                        </DataTableRow>
                    </DataTableBody>
                </DataTableContent>
                <DataTablePagination v-model:page="filters.page" v-model:per-page="filters.per_page" />
            </DataTable>
        </SectionContent>
    </Section>
</template>
