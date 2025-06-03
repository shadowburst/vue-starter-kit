<script setup lang="ts" generic="TData">
import { LoadingIcon } from '@/components/ui/custom/loading';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { TabsContent } from '@/components/ui/tabs';
import { injectDataTableRootContext } from './DataTable.vue';
import type { DataTableTab } from './interface';

type Props = {
    tab: DataTableTab;
};
defineProps<Props>();

const { loading, rows } = injectDataTableRootContext<TData>();
</script>

<template>
    <TabsContent class="grid rounded-md border" v-if="tab === 'table'" :value="tab">
        <ScrollArea class="overflow-auto">
            <Table v-if="loading">
                <TableHeader>
                    <TableRow>
                        <TableHead class="h-14"> </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="i in 15" :key="i">
                        <TableCell class="h-14"> </TableCell>
                    </TableRow>
                </TableBody>
                <div class="absolute inset-0 grid place-items-center">
                    <LoadingIcon variant="primary" />
                </div>
            </Table>
            <Table v-else>
                <slot />
            </Table>
            <ScrollBar orientation="horizontal" />
        </ScrollArea>
    </TabsContent>
    <TabsContent v-else-if="tab === 'card'" :value="tab">
        <div class="grid place-items-center p-4" v-if="loading">
            <LoadingIcon variant="primary" />
        </div>
        <template v-else-if="rows.length">
            <slot />
        </template>
        <template v-else>
            <div class="grid place-items-center">
                <CapitalizeText>
                    {{ $t('components.ui.custom.data_table.empty') }}
                </CapitalizeText>
            </div>
        </template>
    </TabsContent>
</template>
