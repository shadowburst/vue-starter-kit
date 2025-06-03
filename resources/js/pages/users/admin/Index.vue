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
import UserAvatar from '@/components/user/UserAvatar.vue';
import { useAlert, useFilters, useFormatter, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import type {
    TrashedFilter,
    UserAdminIndexProps,
    UserAdminIndexRequest,
    UserAdminIndexResource,
    UserOneOrManyRequest,
} from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { trans, transChoice } from 'laravel-vue-i18n';
import { ArchiveIcon, ArchiveRestoreIcon, CirclePlusIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';
import { ref } from 'vue';

defineOptions({
    layout: useLayout(AdminLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.users.admin.index.title'),
                href: route('admin.users.index'),
            },
        ],
    })),
});

const props = defineProps<UserAdminIndexProps>();

const alert = useAlert();

const selectedRows = ref<UserAdminIndexResource[]>([]);
const rowsActions: DataTableRowsAction<UserAdminIndexResource>[] = [
    {
        label: trans('trash'),
        icon: ArchiveIcon,
        disabled: (items) => items.some((user) => !user.can_trash),
        callback: (items) =>
            alert({
                variant: 'warning',
                description: transChoice('messages.users.trash.confirm', items.length),
                callback: () =>
                    router.delete<UserOneOrManyRequest>(route('admin.users.trash'), {
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
                description: transChoice('messages.users.restore.confirm', items.length),
                callback: () =>
                    router.patch<UserOneOrManyRequest>(
                        route('admin.users.restore'),
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
                description: transChoice('messages.users.delete.confirm', items.length),
                callback: () =>
                    router.delete<UserOneOrManyRequest>(route('admin.users.delete'), {
                        data: { ids: items.map(({ id }) => id) },
                        only: ['users'],
                        onSuccess: () => {
                            selectedRows.value = [];
                        },
                    }),
            }),
    },
];
const rowActions: DataTableRowAction<UserAdminIndexResource>[] = [
    {
        type: 'href',
        label: trans('edit'),
        icon: PencilIcon,
        href: (user) => route('admin.users.edit', { user }),
    },
    {
        type: 'callback',
        label: trans('trash'),
        icon: ArchiveIcon,
        disabled: (user) => !user.can_trash,
        callback: (user) =>
            alert({
                variant: 'warning',
                description: transChoice('messages.users.trash.confirm', 1),
                callback: () =>
                    router.delete<UserOneOrManyRequest>(route('admin.users.trash', { user }), {
                        only: ['users'],
                    }),
            }),
    },
    {
        type: 'callback',
        label: trans('restore'),
        icon: ArchiveRestoreIcon,
        disabled: (user) => !user.can_restore,
        callback: (user) =>
            alert({
                variant: 'success',
                description: transChoice('messages.users.restore.confirm', 1),
                callback: () =>
                    router.patch<UserOneOrManyRequest>(route('admin.users.restore', { user }), undefined, {
                        only: ['users'],
                    }),
            }),
    },
    {
        type: 'callback',
        label: trans('delete'),
        icon: Trash2Icon,
        disabled: (user) => !user.can_delete,
        callback: (user) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.users.delete.confirm', 1),
                callback: () =>
                    router.delete<UserOneOrManyRequest>(route('admin.users.delete', { user }), {
                        only: ['users'],
                    }),
            }),
    },
];

const filters = useFilters<UserAdminIndexRequest>(
    route('admin.users.index'),
    {
        q: route().params.q ?? '',
        page: props.users?.meta.current_page,
        per_page: props.users?.meta.per_page,
        sort_by: route().params.sort_by,
        sort_direction: route().params.sort_direction,
        trashed: route().params.trashed as TrashedFilter | undefined,
    },
    {
        only: ['users'],
        immediate: true,
        debounceReload(key) {
            return !['page', 'per_page'].includes(key);
        },
        onReload(key) {
            if (key !== 'page') {
                filters.page = 1;
            }
        },
    },
);

const format = useFormatter();
</script>

<template>
    <Head :title="$t('pages.users.admin.index.title')" />

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
                    <FiltersSheet :filters :omit="['q', 'page', 'per_page', 'sort_by', 'sort_direction']">
                        <FiltersSheetTrigger />
                        <FiltersSheetContent>
                            <FormField>
                                <FormLabel>
                                    <CapitalizeText>
                                        {{ $t('models.user.fields.is_trashed') }}
                                    </CapitalizeText>
                                </FormLabel>
                                <FormControl>
                                    <EnumCombobox v-model="filters.trashed" data="enums.trashed_filters" />
                                </FormControl>
                            </FormField>
                        </FiltersSheetContent>
                    </FiltersSheet>
                </FormContent>
                <FormContent class="flex items-center justify-between">
                    <DataTableRowsActions />
                    <Button as-child>
                        <InertiaLink :href="route('admin.users.create')">
                            <CirclePlusIcon />
                            <CapitalizeText>
                                {{ $t('pages.users.admin.create.title') }}
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
                                <Badge v-if="user.deleted_at" variant="destructive">
                                    {{ format.date(user.deleted_at) }}
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
