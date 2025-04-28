<script setup lang="ts" generic="TData extends object">
import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Link } from '@inertiajs/vue3';
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
        <div class="flex items-center gap-x-6">
            <div class="flex items-center space-x-2">
                <p class="text-sm font-medium">Rows per page</p>
                <Select v-model.number="pageSize">
                    <SelectTrigger class="h-8 w-[70px]">
                        <SelectValue :placeholder="`${pageSize}`" />
                    </SelectTrigger>
                    <SelectContent side="top">
                        <SelectItem v-for="pageSize in [10, 20, 30, 40, 50]" :key="pageSize" :value="`${pageSize}`">
                            {{ pageSize }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex w-[100px] items-center justify-center text-sm font-medium">
                Page {{ pagination.meta.current_page }} of
                {{ pagination.meta.last_page }}
            </div>
            <div class="flex items-center space-x-2">
                <Button
                    class="hidden size-8 p-0 lg:flex"
                    variant="outline"
                    :disabled="pagination.meta.current_page === 1"
                >
                    <Link :href="pagination.meta.first_page_url ?? '#'">
                        <span class="sr-only">Go to first page</span>
                        <ChevronsLeftIcon />
                    </Link>
                </Button>
                <Button class="size-8 p-0" variant="outline" :disabled="pagination.meta.current_page === 1">
                    <Link :href="pagination.meta.prev_page_url ?? '#'">
                        <span class="sr-only">Go to previous page</span>
                        <ChevronLeftIcon />
                    </Link>
                </Button>
                <Button
                    class="size-8 p-0"
                    variant="outline"
                    :disabled="pagination.meta.current_page === pagination.meta.last_page"
                >
                    <Link :href="pagination.meta.next_page_url ?? '#'">
                        <span class="sr-only">Go to next page</span>
                        <ChevronRightIcon />
                    </Link>
                </Button>
                <Button
                    class="hidden size-8 p-0 lg:flex"
                    variant="outline"
                    :disabled="pagination.meta.current_page === pagination.meta.last_page"
                >
                    <Link :href="pagination.meta.last_page_url ?? '#'">
                        <span class="sr-only">Go to last page</span>
                        <ChevronsRightIcon />
                    </Link>
                </Button>
            </div>
        </div>
    </div>
</template>
