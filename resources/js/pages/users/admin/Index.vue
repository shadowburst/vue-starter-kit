<script setup lang="ts">
import { Button } from '@/components/ui/button';
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
import { FormContent } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { InertiaLink } from '@/components/ui/custom/link';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import UserAvatar from '@/components/user/UserAvatar.vue';
import { useAlert, useFilters, useFormatter, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import type { UserAdminIndexProps, UserAdminIndexRequest, UserAdminIndexResource, UserOneOrManyRequest } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { trans, transChoice } from 'laravel-vue-i18n';
import { CirclePlusIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';
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
        label: trans('delete'),
        icon: Trash2Icon,
        callback: (items) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.users.delete.confirm', items.length),
                callback: () =>
                    router.delete<UserOneOrManyRequest>(route('admin.users.destroy'), {
                        data: { ids: items.map(({ id }) => id) },
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
        label: trans('delete'),
        icon: Trash2Icon,
        callback: (user) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.users.delete.confirm', 1),
                callback: () => router.delete<UserOneOrManyRequest>(route('admin.users.destroy', { user })),
            }),
    },
];

const filters = useFilters<UserAdminIndexRequest>(
    {
        q: route().params.q ?? '',
        is_trashed: route().params.is_enabled == undefined ? undefined : Boolean(route().params.is_enabled),
        page: props.users.meta.current_page,
        per_page: props.users.meta.per_page,
        sort_by: route().params.sort_by ?? 'id',
        sort_direction: route().params.sort_direction ?? 'desc',
    },
    {
        only: ['users'],
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
                :data="props.users"
                :rows-actions
                :row-actions
            >
                <FormContent class="flex items-center">
                    <TextInput v-model="filters.q" type="search" />
                    <FiltersSheet :filters :omit="['q', 'page', 'per_page', 'sort_by', 'sort_direction']">
                        <FiltersSheetTrigger />
                        <FiltersSheetContent> </FiltersSheetContent>
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
                            <DataTableSortableHead value="name">
                                {{ $t('models.user.fields.full_name') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="email">
                                {{ $t('models.user.fields.email') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="deleted_at">
                                {{ $t('is_trashed') }}
                            </DataTableSortableHead>
                            <DataTableHead>
                                <DataTableHeadActions />
                            </DataTableHead>
                        </DataTableRow>
                    </DataTableHeader>
                    <DataTableBody>
                        <DataTableRow v-for="user in rows" :key="user.id" :item="user">
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
                                {{ user.is_trashed }}
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
