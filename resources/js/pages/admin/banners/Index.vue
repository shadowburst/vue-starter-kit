<script setup lang="ts">
import {
    DataTable,
    DataTableBody,
    DataTableCell,
    DataTableContent,
    DataTableHead,
    DataTableHeader,
    DataTablePagination,
    DataTableRow,
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
import { useFilters, useFormatter, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import type { BannerAdminIndexProps, BannerAdminIndexRequest, BannerAdminIndexResource } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { reactiveOmit } from '@vueuse/core';
import { trans } from 'laravel-vue-i18n';
import { ArchiveIcon } from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({
    layout: useLayout(AdminLayout, () => ({
        breadcrumbs: [
            {
                title: trans('pages.admin.banners.index.title'),
                href: route('admin.banners.index'),
            },
        ],
    })),
});

const props = defineProps<BannerAdminIndexProps>();

const rowsActions: DataTableRowsAction<BannerAdminIndexResource>[] = [
    {
        label: trans('archive'),
        icon: ArchiveIcon,
        callback: (items) => console.log(items),
    },
];

const filters = useFilters<BannerAdminIndexRequest>(
    {
        q: route().params.q ?? '',
        page: Number(route().params.page ?? 1),
        per_page: Number(route().params.per_page ?? usePage().props.default.per_page),
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
            <DataTable v-slot="{ rows }" :data="props.banners" :rows-actions>
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
                        </DataTableRow>
                    </DataTableBody>
                </DataTableContent>
                <DataTablePagination v-model:per-page="filters.per_page" @update:per-page="filters.page = 1" />
            </DataTable>
        </SectionContent>
    </Section>
</template>
