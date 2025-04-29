<script setup lang="ts">
import {
    DataTable,
    DataTableCell,
    DataTableHead,
    DataTableRow,
    DataTableRowCheckbox,
    DataTableRowsAction,
    DataTableRowsCheckbox,
} from '@/components/ui/data-table';
import { useLayout } from '@/composables';
import { format } from '@/helpers';
import { AdminLayout } from '@/layouts';
import type { BannerAdminIndexProps, BannerAdminIndexResource, BreadcrumbItem, SharedData } from '@/types';
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
        ] as BreadcrumbItem[],
    })),
});

type Props = SharedData & BannerAdminIndexProps;
const props = defineProps<Props>();

const massActions: DataTableRowsAction<BannerAdminIndexResource>[] = [
    {
        label: trans('archive'),
        icon: ArchiveIcon,
        callback: (items) => console.log(items),
    },
];
</script>

<template>
    <Head :title="trans('pages.admin.banners.index.title')" />

    <DataTable :data="props.banners" :mass-actions>
        <template #headers>
            <DataTableRow>
                <DataTableHead>
                    <DataTableRowsCheckbox />
                </DataTableHead>
                <DataTableHead>
                    {{ $t('models.banner.fields.name') }}
                </DataTableHead>
                <DataTableHead>
                    {{ $t('models.banner.fields.starts_at') }}
                </DataTableHead>
                <DataTableHead>
                    {{ $t('models.banner.fields.ends_at') }}
                </DataTableHead>
            </DataTableRow>
        </template>
        <template #rows="{ view, items }">
            <template v-for="item in items" :key="item.id">
                <DataTableRow v-if="view === 'table'" :item>
                    <DataTableCell>
                        <DataTableRowCheckbox />
                    </DataTableCell>
                    <DataTableCell>
                        {{ item.name }}
                    </DataTableCell>
                    <DataTableCell>
                        {{ format.date(item.starts_at) }}
                    </DataTableCell>
                    <DataTableCell>
                        {{ format.date(item.ends_at) }}
                    </DataTableCell>
                </DataTableRow>
            </template>
        </template>
    </DataTable>
</template>
