<script setup lang="ts" generic="TData extends object">
import { Capitalize } from '@/components/typography';
import { Button } from '@/components/ui/button';
import { InertiaLink } from '@/components/ui/link';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ChevronLeftIcon, ChevronRightIcon, ChevronsLeftIcon, ChevronsRightIcon } from 'lucide-vue-next';
import { computed } from 'vue';
import { useDataTableRootContext } from './DataTable.vue';

const { rows, selectedRows, pagination, setPageSize } = useDataTableRootContext<TData>();
const pageSize = computed<number>({
    get: () => pagination.value!.meta.per_page,
    set: (value) => setPageSize(value),
});
</script>

<template>
    <div class="flex items-center justify-between" v-if="pagination">
        <div class="text-muted-foreground flex-1 text-sm">
            {{
                $t('components.ui.data_table.selected', {
                    selected: selectedRows.length.toString(),
                    rows: rows.length.toString(),
                })
            }}
        </div>
        <div class="flex items-center space-x-2">
            <p class="text-sm font-medium">Rows per page</p>
            <Select v-model.number="pageSize">
                <SelectTrigger class="h-8 w-[70px]">
                    <SelectValue :placeholder="`${pageSize}`" />
                </SelectTrigger>
                <SelectContent side="top">
                    <SelectItem v-for="pageSize in [15, 30, 50, 100]" :key="pageSize" :value="`${pageSize}`">
                        {{ pageSize }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>
        <div class="flex w-[100px] items-center justify-center text-sm font-medium">
            <Capitalize>
                {{
                    $t('components.ui.data_table.pages', {
                        current: pagination.meta.current_page.toString(),
                        total: pagination.meta.last_page.toString(),
                    })
                }}
            </Capitalize>
        </div>
        <div class="flex items-center space-x-2">
            <Button
                class="max-lg:hidden"
                as-child
                size="icon"
                variant="outline"
                :disabled="pagination.meta.current_page === 1"
            >
                <InertiaLink :href="pagination.meta.first_page_url">
                    <span class="sr-only">Go to first page</span>
                    <ChevronsLeftIcon />
                </InertiaLink>
            </Button>
            <Button as-child size="icon" variant="outline" :disabled="pagination.meta.current_page === 1">
                <InertiaLink :href="pagination.meta.prev_page_url">
                    <span class="sr-only">Go to previous page</span>
                    <ChevronLeftIcon />
                </InertiaLink>
            </Button>
            <Button
                as-child
                size="icon"
                variant="outline"
                :disabled="pagination.meta.current_page === pagination.meta.last_page"
            >
                <InertiaLink :href="pagination.meta.next_page_url">
                    <span class="sr-only">Go to next page</span>
                    <ChevronRightIcon />
                </InertiaLink>
            </Button>
            <Button
                class="max-lg:hidden"
                as-child
                size="icon"
                variant="outline"
                :disabled="pagination.meta.current_page === pagination.meta.last_page"
            >
                <InertiaLink :href="pagination.meta.last_page_url ?? '#'">
                    <span class="sr-only">Go to last page</span>
                    <ChevronsRightIcon />
                </InertiaLink>
            </Button>
        </div>
    </div>
</template>
