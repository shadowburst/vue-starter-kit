<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button, ButtonProps } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { SheetTrigger } from '@/components/ui/sheet';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { FunnelIcon } from 'lucide-vue-next';
import { useForwardProps } from 'reka-ui';
import { injectFiltersSheetRootContext } from './FiltersSheet.vue';

const props = withDefaults(defineProps<ButtonProps>(), {
    variant: 'outline',
});
const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardProps(delegatedProps);

const { count } = injectFiltersSheetRootContext();
</script>

<template>
    <SheetTrigger as-child>
        <Button v-bind="forwarded" :class="cn('relative', props.class)">
            <FunnelIcon />
            <CapitalizeText>
                {{ $t('filter') }}
            </CapitalizeText>
            <Badge class="absolute top-0 right-0 size-2 translate-x-1/2 -translate-y-1/2 p-1.5 text-xs" v-if="count">
                {{ count > 9 ? '+' : count }}
            </Badge>
        </Button>
    </SheetTrigger>
</template>
