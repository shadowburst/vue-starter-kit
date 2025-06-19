<script setup lang="ts">
import TrashedBadge from '@/components/trash/TrashedBadge.vue';
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
    DataTableRowsCheckbox,
    DataTableSortableHead,
} from '@/components/ui/custom/data-table';
import { FiltersSheet, FiltersSheetContent, FiltersSheetTrigger } from '@/components/ui/custom/filters';
import { FormContent, FormControl, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { InertiaLink } from '@/components/ui/custom/link';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { useAlert, useFilters, useLayout } from '@/composables';
import { AppLayout } from '@/layouts';
import type {
    UserMemberIndexProps,
    UserMemberIndexRequest,
    UserMemberIndexResource,
    UserMemberOneOrManyRequest,
} from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { trans, transChoice } from 'laravel-vue-i18n';
import { ArchiveIcon, ArchiveRestoreIcon, CirclePlusIcon, EyeIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';
import { ref } from 'vue';

defineOptions({
    layout: useLayout(AppLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.users.members.index.title'),
                href: route('users.members.index'),
            },
        ],
    })),
});

const props = defineProps<UserMemberIndexProps>();

const alert = useAlert();

const selectedRows = ref<UserMemberIndexResource[]>([]);
const rowsActions: DataTableRowsAction<UserMemberIndexResource>[] = [
    {
        label: trans('trash'),
        icon: ArchiveIcon,
        disabled: (items) => items.some((user) => !user.can_trash),
        callback: (items) =>
            alert({
                variant: 'warning',
                description: transChoice('messages.users.members.trash.confirm', items.length),
                callback: () =>
                    router.delete<UserMemberOneOrManyRequest>(route('users.members.trash'), {
                        data: { ids: items.map(({ id }) => id) },
                        only: ['users'],
                        onSuccess: () => {
                            selectedRows.value = [];
                        },
                    }),
            }),
    },
    {
        label: trans('restore'),
        icon: ArchiveRestoreIcon,
        disabled: (items) => items.some((user) => !user.can_restore),
        callback: (items) =>
            alert({
                variant: 'success',
                description: transChoice('messages.users.members.restore.confirm', items.length),
                callback: () =>
                    router.patch<UserMemberOneOrManyRequest>(
                        route('users.members.restore'),
                        { ids: items.map(({ id }) => id) },
                        {
                            only: ['users'],
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
        disabled: (items) => items.some((user) => !user.can_delete),
        callback: (items) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.users.members.delete.confirm', items.length),
                callback: () =>
                    router.delete<UserMemberOneOrManyRequest>(route('users.members.delete'), {
                        data: { ids: items.map(({ id }) => id) },
                        only: ['users'],
                        onSuccess: () => {
                            selectedRows.value = [];
                        },
                    }),
            }),
    },
];
const rowActions: DataTableRowAction<UserMemberIndexResource>[] = [
    {
        type: 'href',
        label: trans('edit'),
        icon: PencilIcon,
        hidden: (user) => !user.can_update,
        href: (member) => route('users.members.edit', { member }),
    },
    {
        type: 'href',
        label: trans('view'),
        icon: EyeIcon,
        hidden: (user) => user.can_update,
        disabled: (user) => !user.can_view,
        href: (member) => route('users.members.edit', { member }),
    },
    {
        type: 'callback',
        label: trans('trash'),
        icon: ArchiveIcon,
        disabled: (user) => !user.can_trash,
        callback: (member) =>
            alert({
                variant: 'warning',
                description: transChoice('messages.users.members.trash.confirm', 1),
                callback: () =>
                    router.delete<UserMemberOneOrManyRequest>(route('users.members.trash', { member }), {
                        only: ['users'],
                    }),
            }),
    },
    {
        type: 'callback',
        label: trans('restore'),
        icon: ArchiveRestoreIcon,
        disabled: (user) => !user.can_restore,
        callback: (member) =>
            alert({
                variant: 'success',
                description: transChoice('messages.users.members.restore.confirm', 1),
                callback: () =>
                    router.patch<UserMemberOneOrManyRequest>(route('users.members.restore', { member }), undefined, {
                        only: ['users'],
                    }),
            }),
    },
    {
        type: 'callback',
        label: trans('delete'),
        icon: Trash2Icon,
        disabled: (user) => !user.can_delete,
        callback: (member) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.users.members.delete.confirm', 1),
                callback: () =>
                    router.delete<UserMemberOneOrManyRequest>(route('users.members.delete', { member }), {
                        only: ['users'],
                    }),
            }),
    },
];

const filters = useFilters<UserMemberIndexRequest>(
    route('users.members.index'),
    {
        q: props.request.q ?? '',
        page: props.request.page ?? props.users?.meta.current_page,
        per_page: props.request.per_page ?? props.users?.meta.per_page,
        sort_by: props.request.sort_by,
        sort_direction: props.request.sort_direction,
        trashed: props.request.trashed,
    },
    {
        only: ['users'],
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
</script>

<template>
    <Head :title="$t('pages.users.members.index.title')" />

    <Section>
        <SectionContent>
            <DataTable
                v-slot="{ rows }"
                v-model:selected-rows="selectedRows"
                v-model:sort-by="filters.sort_by"
                v-model:sort-direction="filters.sort_direction"
                :data="users"
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
                    <Button class="ml-auto" as-child>
                        <InertiaLink :href="route('users.members.create')">
                            <CirclePlusIcon />
                            <CapitalizeText class="max-sm:hidden">
                                {{ $t('pages.users.members.create.title') }}
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
                            <DataTableSortableHead value="full_name">
                                {{ $t('models.user.fields.full_name') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="email">
                                {{ $t('models.user.fields.email') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="phone">
                                {{ $t('models.user.fields.phone') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead v-if="filters.trashed" value="deleted_at">
                                {{ $t('models.user.fields.deleted_at') }}
                            </DataTableSortableHead>
                            <DataTableHead>
                                <DataTableHeadActions />
                            </DataTableHead>
                        </DataTableRow>
                    </DataTableHeader>
                    <DataTableBody>
                        <DataTableRow
                            v-for="user in rows"
                            :key="user.id"
                            :item="user"
                            :class="{ 'bg-destructive/5': user.deleted_at }"
                        >
                            <DataTableCell>
                                <DataTableRowCheckbox />
                            </DataTableCell>
                            <DataTableCell>
                                <div class="flex items-center gap-2">
                                    <UserAvatar :user />
                                    <CapitalizeText>
                                        {{ user.full_name }}
                                    </CapitalizeText>
                                </div>
                            </DataTableCell>
                            <DataTableCell>
                                {{ user.email }}
                            </DataTableCell>
                            <DataTableCell>
                                {{ user.phone }}
                            </DataTableCell>
                            <DataTableCell v-if="filters.trashed">
                                <TrashedBadge :item="user" />
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
