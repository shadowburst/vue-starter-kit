<script setup lang="ts" generic="TData">
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Empty, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import { TableBody, TableCell, TableRow } from '@/components/ui/table';
import { PackageOpenIcon } from 'lucide-vue-next';
import { injectDataTableRootContext } from './DataTable.vue';

const { rows } = injectDataTableRootContext<TData>();
</script>

<template>
    <TableBody>
        <template v-if="rows.length">
            <slot />
        </template>
        <template v-else>
            <TableRow>
                <TableCell colspan="100">
                    <Empty>
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <PackageOpenIcon />
                            </EmptyMedia>
                            <EmptyTitle>
                                <CapitalizeText>
                                    {{ $t('components.ui.custom.data_table.empty') }}
                                </CapitalizeText>
                            </EmptyTitle>
                        </EmptyHeader>
                    </Empty>
                </TableCell>
            </TableRow>
        </template>
    </TableBody>
</template>
