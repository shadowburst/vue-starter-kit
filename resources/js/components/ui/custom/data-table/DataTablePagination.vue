<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ChevronLeftIcon, ChevronRightIcon, ChevronsLeftIcon, ChevronsRightIcon } from 'lucide-vue-next';
import { injectDataTableRootContext } from './DataTable.vue';

const { rows, selectedRows, pagination } = injectDataTableRootContext<TData>();

const page = defineModel<number>('page', {
    default: 1,
});

const perPage = defineModel<number | undefined>('perPage', {
    get(value) {
        return value ?? pagination.value?.meta?.per_page;
    },
});
</script>

<template>
    <div class="flex gap-4" v-if="pagination">
        <div class="text-muted-foreground flex-1 text-sm">
            {{
                $t('components.ui.custom.data_table.selected', {
                    selected: selectedRows.length.toString(),
                    rows: rows.length.toString(),
                })
            }}
        </div>
        <div class="ml-auto flex flex-wrap justify-end gap-y-2 max-sm:w-min">
            <div class="flex items-center gap-x-2">
                <CapitalizeText class="text-sm font-medium">
                    {{ $t('components.ui.custom.data_table.rows_per_page') }}
                </CapitalizeText>
                <Select v-model.number="perPage">
                    <SelectTrigger class="w-[80px]">
                        <SelectValue :placeholder="`${perPage}`" />
                    </SelectTrigger>
                    <SelectContent side="top">
                        <SelectItem v-for="perPage in [15, 50, 100, 200]" :key="perPage" :value="`${perPage}`">
                            {{ perPage }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex items-center gap-x-2">
                <div class="flex w-[100px] items-center justify-center text-sm font-medium">
                    <CapitalizeText>
                        {{
                            $t('components.ui.custom.data_table.pages', {
                                current: page.toString(),
                                total: pagination.meta.last_page.toString(),
                            })
                        }}
                    </CapitalizeText>
                </div>
                <Button class="max-lg:hidden" size="icon" variant="outline" :disabled="page === 1" @click="page = 1">
                    <span class="sr-only">Go to first page</span>
                    <ChevronsLeftIcon />
                </Button>
                <Button size="icon" variant="outline" :disabled="page === 1" @click="page -= 1">
                    <span class="sr-only">Go to previous page</span>
                    <ChevronLeftIcon />
                </Button>
                <Button size="icon" variant="outline" :disabled="page === pagination.meta.last_page" @click="page += 1">
                    <span class="sr-only">Go to next page</span>
                    <ChevronRightIcon />
                </Button>
                <Button
                    class="max-lg:hidden"
                    size="icon"
                    variant="outline"
                    :disabled="page === pagination.meta.last_page"
                    @click="page = pagination.meta.last_page"
                >
                    <span class="sr-only">Go to last page</span>
                    <ChevronsRightIcon />
                </Button>
            </div>
        </div>
    </div>
</template>
