<script setup lang="ts">
import { TrashedBadge } from '@/components/trash';
import { DataTable } from '@/components/ui/custom/data-table-v2';
import { InertiaLink } from '@/components/ui/custom/link';
import { Section, SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { UserAvatar } from '@/components/user';
import { useAlert, useFiltersForm, useLayout } from '@/composables';
import { useUserTable } from '@/composables/user';
import { AppLayout } from '@/layouts';
import type { UserMemberIndexProps, UserMemberOneOrManyRequest } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { trans, transChoice } from 'laravel-vue-i18n';
import { ArchiveIcon, ArchiveRestoreIcon, EyeIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';
import { onMounted } from 'vue';

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

const { filters, reload } = useFiltersForm(props.request, {
    only: ['users', 'request'],
});
onMounted(() => reload());

const alert = useAlert();
const { table, columns } = useUserTable({
    data: () => props.users ?? [],
    selectedActions: (items) => [
        {
            label: trans('trash'),
            icon: ArchiveIcon,
            callback: () =>
                alert({
                    variant: 'destructive',
                    description: transChoice('messages.users.members.trash.confirm', items.length),
                    callback: () =>
                        router.delete<UserMemberOneOrManyRequest>(route('users.members.trash'), {
                            data: { ids: items.map(({ id }) => id) },
                            only: ['users'],
                            onSuccess: () => {
                                table.resetRowSelection(true);
                            },
                        }),
                }),
            disabled: items.some((member) => !member.policy?.trash),
        },
        {
            label: trans('restore'),
            icon: ArchiveRestoreIcon,
            callback: () =>
                alert({
                    description: transChoice('messages.users.members.restore.confirm', items.length),
                    callback: () =>
                        router.patch<UserMemberOneOrManyRequest>(
                            route('users.members.restore'),
                            { ids: items.map(({ id }) => id) },
                            {
                                only: ['users'],
                                onSuccess: () => {
                                    table.resetRowSelection(true);
                                },
                            },
                        ),
                }),
            disabled: items.some((member) => !member.policy?.restore),
        },
        {
            label: trans('delete'),
            icon: Trash2Icon,
            callback: () =>
                alert({
                    variant: 'destructive',
                    description: transChoice('messages.users.members.delete.confirm', items.length),
                    callback: () =>
                        router.delete<UserMemberOneOrManyRequest>(route('users.members.delete'), {
                            data: { ids: items.map(({ id }) => id) },
                            only: ['users'],
                            onSuccess: () => {
                                table.resetRowSelection(true);
                            },
                        }),
                }),
            disabled: items.some((member) => !member.policy?.delete),
        },
    ],
    rowActions: (member) => [
        {
            label: trans('edit'),
            icon: PencilIcon,
            href: route('users.members.edit', { member }),
            hidden: !member.policy?.update,
        },
        {
            label: trans('view'),
            icon: EyeIcon,
            href: route('users.members.edit', { member }),
            hidden: member.policy?.update ?? false,
            disabled: !member.policy?.view,
        },
        {
            label: trans('trash'),
            icon: Trash2Icon,
            callback: () =>
                alert({
                    variant: 'destructive',
                    description: transChoice('messages.users.members.trash.confirm', 1),
                    callback: () =>
                        router.delete<UserMemberOneOrManyRequest>(route('users.members.trash', { member }), {
                            only: ['users'],
                        }),
                }),
            disabled: !member.policy?.trash,
        },
        {
            label: trans('restore'),
            icon: ArchiveRestoreIcon,
            callback: () =>
                alert({
                    description: transChoice('messages.users.members.restore.confirm', 1),
                    callback: () =>
                        router.patch<UserMemberOneOrManyRequest>(
                            route('users.members.restore', { member }),
                            undefined,
                            {
                                only: ['users'],
                            },
                        ),
                }),
            disabled: !member.policy?.restore,
        },
        {
            label: trans('delete'),
            icon: Trash2Icon,
            callback: () =>
                alert({
                    variant: 'destructive',
                    description: transChoice('messages.users.members.delete.confirm', 1),
                    callback: () =>
                        router.delete<UserMemberOneOrManyRequest>(route('users.members.delete', { member }), {
                            only: ['users'],
                        }),
                }),
            disabled: !member.policy?.delete,
        },
    ],
    onPaginationChange: () => {
        filters.page = table.getState().pagination.pageIndex + 1;
        filters.per_page = table.getState().pagination.pageSize;
        reload();
    },
});
</script>

<template>
    <Head :title="$t('pages.users.members.index.title')" />

    <Section>
        <SectionContent>
            <DataTable :table :columns :multi-actions :row-actions>
                <template #full_name="{ row }">
                    <InertiaLink
                        :href="route('users.members.edit', { member: row.original })"
                        class="flex items-center gap-2"
                    >
                        <UserAvatar :user="row.original" />
                        <CapitalizeText>
                            {{ row.original.full_name }}
                        </CapitalizeText>
                    </InertiaLink>
                </template>
                <template #deleted_at="{ row }">
                    <TrashedBadge :date="row.original.deleted_at" />
                </template>
            </DataTable>
        </SectionContent>
    </Section>
</template>
