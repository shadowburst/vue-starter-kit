<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { SheetTrigger } from '@/components/ui/sheet';
import { cn } from '@/lib/utils';
import { FunnelIcon, XIcon } from 'lucide-vue-next';
import { HTMLAttributes } from 'vue';
import { injectFiltersSheetRootContext } from './FiltersSheet.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { filters, fields, count } = injectFiltersSheetRootContext();
</script>

<template>
    <div :class="cn('relative flex items-stretch', props.class)">
        <SheetTrigger as-child>
            <Button variant="outline" :class="{ 'rounded-r-none border-r-0': count > 0 }">
                <FunnelIcon />
                <CapitalizeText class="max-sm:hidden">
                    {{ $t('filter') }}
                </CapitalizeText>
            </Button>
        </SheetTrigger>
        <template v-if="count > 0">
            <Button class="rounded-l-none" variant="outline" size="icon" @click="filters.reset(...fields)">
                <XIcon />
            </Button>
            <Badge class="absolute top-0 right-0 size-2 translate-x-1/2 -translate-y-1/2 p-1.5 text-xs">
                {{ count > 9 ? '+' : count }}
            </Badge>
        </template>
    </div>
</template>
