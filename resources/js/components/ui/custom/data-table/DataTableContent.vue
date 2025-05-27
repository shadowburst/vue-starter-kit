<script setup lang="ts" generic="TData">
import { CapitalizeText } from '@/components/ui/custom/typography';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Table } from '@/components/ui/table';
import { TabsContent } from '@/components/ui/tabs';
import { injectDataTableRootContext } from './DataTable.vue';
import type { DataTableTab } from './interface';

type Props = {
    tab: DataTableTab;
};
defineProps<Props>();

const { rows } = injectDataTableRootContext<TData>();
</script>

<template>
    <TabsContent class="grid rounded-md border" v-if="tab === 'table'" :value="tab">
        <ScrollArea class="overflow-auto">
            <Table>
                <slot />
            </Table>
            <ScrollBar orientation="horizontal" />
        </ScrollArea>
    </TabsContent>
    <TabsContent v-else-if="tab === 'card'" :value="tab">
        <template v-if="rows.length">
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
