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
import { TextInput } from '@/components/ui/custom/input';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { useFormatter, useLayout } from '@/composables';
import { AdminLayout } from '@/layouts';
import type { BannerAdminIndexProps, BannerAdminIndexResource } from '@/types';
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { ArchiveIcon } from 'lucide-vue-next';

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

const format = useFormatter();
</script>

<template>
    <Head :title="trans('pages.admin.banners.index.title')" />

    <Section>
        <SectionContent>
            <div class="flex items-center gap-2">
                <TextInput type="search" />
                <FiltersSheet>
                    <FiltersSheetTrigger />
                    <FiltersSheetContent> </FiltersSheetContent>
                </FiltersSheet>
            </div>
            <DataTable v-slot="{ rows }" :data="props.banners" :rows-actions>
                <div class="flex items-center justify-between gap-2">
                    <DataTableRowsActions />
                </div>
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
                                {{ banner.name }}
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
                <DataTablePagination />
            </DataTable>
        </SectionContent>
    </Section>
</template>
