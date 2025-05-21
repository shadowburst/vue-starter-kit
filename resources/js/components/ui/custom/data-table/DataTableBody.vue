<script setup lang="ts" generic="TData">
import { CapitalizeText } from '@/components/ui/custom/typography';
import { TableBody, TableCell, TableRow } from '@/components/ui/table';
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
                <TableCell class="h-24 text-center" colspan="100">
                    <CapitalizeText>
                        {{ $t('components.ui.custom.data_table.empty') }}
                    </CapitalizeText>
                </TableCell>
            </TableRow>
        </template>
    </TableBody>
</template>
