<script setup lang="ts">
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
} from '@/components/ui/custom/data-table';
import { FiltersSheet, FiltersSheetContent, FiltersSheetTrigger } from '@/components/ui/custom/filters';
import { FormContent } from '@/components/ui/custom/form';
import { TextInput } from '@/components/ui/custom/input';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useAlert, useFilters, useFormatter, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import type { BannerAdminIndexProps, BannerAdminIndexRequest, BannerAdminIndexResource } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { reactiveOmit } from '@vueuse/core';
import { trans, transChoice } from 'laravel-vue-i18n';
import { PencilIcon, Trash2Icon } from 'lucide-vue-next';
import { computed, ref } from 'vue';

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
        label: trans('delete'),
        icon: Trash2Icon,
        callback: (items) =>
            alert({
                variant: 'destructive',
                description: transChoice('messages.banners.delete.confirm', items.length),
                callback: () =>
                    router.delete(route('admin.banners.destroy'), {
                        data: { ids: items.map(({ id }) => id) },
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
                callback: () => router.delete(route('admin.banners.destroy', { banner })),
            }),
    },
];

const filters = useFilters<BannerAdminIndexRequest>(
    {
        q: route().params.q ?? '',
        page: props.banners.meta.current_page,
        per_page: props.banners.meta.per_page,
    },
    {
        only: ['banners'],
    },
);
const hiddenParams = reactiveOmit(filters.params, 'q', 'page', 'per_page');
const hiddenParamsCount = computed(() => Object.keys(hiddenParams).length);

const format = useFormatter();
</script>

<template>
    <Head :title="$t('pages.admin.banners.index.title')" />

    <Section>
        <SectionContent>
            <DataTable
                v-slot="{ rows }"
                v-model:selected-rows="selectedRows"
                :data="props.banners"
                :rows-actions
                :row-actions
            >
                <FormContent class="flex items-center">
                    <TextInput v-model="filters.q" type="search" />
                    <FiltersSheet>
                        <FiltersSheetTrigger :count="hiddenParamsCount" />
                        <FiltersSheetContent> </FiltersSheetContent>
                    </FiltersSheet>
                </FormContent>
                <FormContent class="flex items-center">
                    <DataTableRowsActions />
                </FormContent>
                <DataTableContent tab="table">
                    <DataTableHeader>
                        <DataTableRow>
                            <DataTableHead>
                                <DataTableRowsCheckbox />
                            </DataTableHead>
                            <DataTableHead>
                                {{ $t('models.banner.fields.name') }}
                            </DataTableHead>
                            <DataTableHead>
                                {{ $t('models.banner.fields.start_date') }}
                            </DataTableHead>
                            <DataTableHead>
                                {{ $t('models.banner.fields.end_date') }}
                            </DataTableHead>
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
