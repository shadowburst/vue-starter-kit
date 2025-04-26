<script setup lang="ts" generic="TData extends object">
import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ChevronLeftIcon, ChevronRightIcon, ChevronsLeftIcon, ChevronsRightIcon } from 'lucide-vue-next';
import { useDataTableRootContext } from './DataTable.vue';

const rootContext = useDataTableRootContext<TData>();
</script>

<template>
    <div class="flex items-center justify-between px-2" v-if="rootContext.pagination.value">
        <div class="text-muted-foreground flex-1 text-sm">
            {{
                $t('components.ui.data_table.selected', {
                    selected: rootContext.selectedRows.value.length.toString(),
                    rows: rootContext.rows.value.length.toString(),
                })
            }}
        </div>
        <div class="flex items-center space-x-6 lg:space-x-8">
            <div class="flex items-center space-x-2">
                <p class="text-sm font-medium">Rows per page</p>
                <Select
                    :model-value="`${rootContext.pagination.value.meta.per_page}`"
                    @update:model-value="table.setPageSize"
                >
                    <SelectTrigger class="h-8 w-[70px]">
                        <SelectValue :placeholder="`${table.getState().pagination.pageSize}`" />
                    </SelectTrigger>
                    <SelectContent side="top">
                        <SelectItem v-for="pageSize in [10, 20, 30, 40, 50]" :key="pageSize" :value="`${pageSize}`">
                            {{ pageSize }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex w-[100px] items-center justify-center text-sm font-medium">
                Page {{ table.getState().pagination.pageIndex + 1 }} of
                {{ table.getPageCount() }}
            </div>
            <div class="flex items-center space-x-2">
                <Button
                    class="hidden h-8 w-8 p-0 lg:flex"
                    variant="outline"
                    :disabled="!table.getCanPreviousPage()"
                    @click="table.setPageIndex(0)"
                >
                    <span class="sr-only">Go to first page</span>
                    <ChevronsLeftIcon />
                </Button>
                <Button
                    class="h-8 w-8 p-0"
                    variant="outline"
                    :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()"
                >
                    <span class="sr-only">Go to previous page</span>
                    <ChevronLeftIcon />
                </Button>
                <Button
                    class="h-8 w-8 p-0"
                    variant="outline"
                    :disabled="!table.getCanNextPage()"
                    @click="table.nextPage()"
                >
                    <span class="sr-only">Go to next page</span>
                    <ChevronRightIcon />
                </Button>
                <Button
                    class="hidden h-8 w-8 p-0 lg:flex"
                    variant="outline"
                    :disabled="!table.getCanNextPage()"
                    @click="table.setPageIndex(table.getPageCount() - 1)"
                >
                    <span class="sr-only">Go to last page</span>
                    <ChevronsRightIcon />
                </Button>
            </div>
        </div>
    </div>
</template>
