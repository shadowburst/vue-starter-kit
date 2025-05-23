<script setup lang="ts">
import { Button, ButtonProps } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { SheetTrigger } from '@/components/ui/sheet';
import { FilterIcon } from 'lucide-vue-next';

const props = withDefaults(defineProps<ButtonProps>(), {
    variant: 'outline',
});
</script>

<template>
    <SheetTrigger as-child>
        <Button v-bind="props">
            <slot>
                <FilterIcon />
                <CapitalizeText>
                    {{ $t('filter') }}
                </CapitalizeText>
            </slot>
        </Button>
    </SheetTrigger>
</template>
