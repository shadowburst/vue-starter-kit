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
import { DatePicker } from '@/components/ui/custom/date-picker';
import { FiltersSheet, FiltersSheetContent, FiltersSheetTrigger } from '@/components/ui/custom/filters';
import { FormContent, FormControl, FormField, FormLabel } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { InertiaLink } from '@/components/ui/custom/link';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Switch } from '@/components/ui/switch';
import { useAlert, useFilters, useFormatter, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import type {
    BannerAdminIndexProps,
    BannerAdminIndexRequest,
    BannerAdminIndexResource,
    BannerOneOrManyRequest,
} from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { trans, transChoice } from 'laravel-vue-i18n';
import { CirclePlusIcon, PencilIcon, ToggleLeftIcon, ToggleRightIcon, Trash2Icon } from 'lucide-vue-next';
import { ref } from 'vue';

defineOptions({
    layout: useLayout(AdminLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.banners.admin.index.title'),
                href: route('admin.banners.index'),
            },
        ],
    })),
});

const props = defineProps<BannerAdminIndexProps>();

const alert = useAlert();

const selectedRows = ref<BannerAdminIndexResource[]>([]);
const rowsActions: DataTableRowsAction<BannerAdminIndexResource>[] = [
    {
        label: trans('enable'),
        icon: ToggleRightIcon,
        callback: (items) =>
            alert({
                description: transChoice('messages.banners.enable.confirm', items.length),
                callback: () =>
                    router.patch<BannerOneOrManyRequest>(
                        route('admin.banners.enable'),
                        {
                            ids: items.map(({ id }) => id),
                        },
                        {
                            only: ['banners'],
                            onSuccess: () => {
                                selectedRows.value = [];
                            },
                        },
                    ),
            }),
    },
    {
        label: trans('disable'),
        icon: ToggleLeftIcon,
        callback: (items) =>
            alert({
                description: transChoice('messages.banners.disable.confirm', items.length),
                callback: () =>
                    router.patch<BannerOneOrManyRequest>(
                        route('admin.banners.disable'),
                        {
                            ids: items.map(({ id }) => id),
                        },
                        {
                            only: ['banners'],
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
        callback: (items) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.banners.delete.confirm', items.length),
                callback: () =>
                    router.delete<BannerOneOrManyRequest>(route('admin.banners.delete'), {
                        data: { ids: items.map(({ id }) => id) },
                        only: ['banners'],
                        onSuccess: () => {
                            selectedRows.value = [];
                        },
                    }),
            }),
    },
];
const rowActions: DataTableRowAction<BannerAdminIndexResource>[] = [
    {
        type: 'href',
        label: trans('edit'),
        icon: PencilIcon,
        href: (banner) => route('admin.banners.edit', { banner }),
    },
    {
        type: 'callback',
        label: trans('delete'),
        icon: Trash2Icon,
        callback: (banner) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.banners.delete.confirm', 1),
                callback: () =>
                    router.delete<BannerOneOrManyRequest>(route('admin.banners.delete', { banner }), {
                        only: ['banners'],
                    }),
            }),
    },
];

const filters = useFilters<BannerAdminIndexRequest>(
    route('admin.banners.index'),
    {
        q: route().params.q ?? '',
        start_date: route().params.start_date,
        end_date: route().params.end_date,
        is_enabled: route().params.is_enabled == undefined ? undefined : Boolean(route().params.is_enabled),
        page: props.banners?.meta.current_page,
        per_page: props.banners?.meta.per_page,
        sort_by: route().params.sort_by,
        sort_direction: route().params.sort_direction,
    },
    {
        only: ['banners'],
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
    <Head :title="$t('pages.banners.admin.index.title')" />

    <Section>
        <SectionContent>
            <DataTable
                v-slot="{ rows }"
                v-model:selected-rows="selectedRows"
                v-model:sort-by="filters.sort_by"
                v-model:sort-direction="filters.sort_direction"
                :data="banners"
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
                                        {{ $t('models.banner.fields.start_date') }}
                                    </CapitalizeText>
                                </FormLabel>
                                <FormControl>
                                    <DatePicker v-model="filters.start_date" :max-value="filters.end_date" />
                                </FormControl>
                            </FormField>
                            <FormField>
                                <FormLabel>
                                    <CapitalizeText>
                                        {{ $t('models.banner.fields.end_date') }}
                                    </CapitalizeText>
                                </FormLabel>
                                <FormControl>
                                    <DatePicker v-model="filters.end_date" :min-value="filters.start_date" />
                                </FormControl>
                            </FormField>
                        </FiltersSheetContent>
                    </FiltersSheet>
                </FormContent>
                <FormContent class="flex items-center justify-between">
                    <DataTableRowsActions />
                    <Button as-child>
                        <InertiaLink :href="route('admin.banners.create')">
                            <CirclePlusIcon />
                            <CapitalizeText>
                                {{ $t('pages.banners.admin.create.title') }}
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
                                {{ $t('models.banner.fields.name') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="start_date">
                                {{ $t('models.banner.fields.start_date') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="end_date">
                                {{ $t('models.banner.fields.end_date') }}
                            </DataTableSortableHead>
                            <DataTableSortableHead value="is_enabled">
                                {{ $t('models.banner.fields.is_enabled') }}
                            </DataTableSortableHead>
                            <DataTableHead>
                                <DataTableHeadActions />
                            </DataTableHead>
                        </DataTableRow>
                    </DataTableHeader>
                    <DataTableBody>
                        <DataTableRow v-for="banner in rows" :key="banner.id" :item="banner">
                            <DataTableCell>
                                <DataTableRowCheckbox />
                            </DataTableCell>
                            <DataTableCell>
                                <CapitalizeText>
                                    {{ banner.name }}
                                </CapitalizeText>
                            </DataTableCell>
                            <DataTableCell>
                                {{ format.date(banner.start_date) }}
                            </DataTableCell>
                            <DataTableCell>
                                {{ format.date(banner.end_date) }}
                            </DataTableCell>
                            <DataTableCell>
                                <Switch
                                    :model-value="banner.is_enabled"
                                    @update:model-value="
                                        $event
                                            ? router.patch(route('admin.banners.enable', { banner }), undefined, {
                                                  only: ['banners'],
                                              })
                                            : router.patch(route('admin.banners.disable', { banner }), undefined, {
                                                  only: ['banners'],
                                              })
                                    "
                                />
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
