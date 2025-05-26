<script setup lang="ts">
import { FormContent } from '@/components/ui/custom/form';
import { CapitalizeText } from '@/components/ui/custom/typography';
import ScrollArea from '@/components/ui/scroll-area/ScrollArea.vue';
import { SheetContent, SheetContentProps, SheetDescription, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps, VisuallyHidden } from 'reka-ui';

const props = defineProps<SheetContentProps>();
const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <SheetContent v-bind="forwarded" :class="cn('w-full', props.class)">
        <SheetHeader>
            <SheetTitle>
                <CapitalizeText>
                    {{ $t('components.ui.custom.filters.sheet.title') }}
                </CapitalizeText>
            </SheetTitle>
            <VisuallyHidden>
                <SheetDescription>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.filters.sheet.description') }}
                    </CapitalizeText>
                </SheetDescription>
            </VisuallyHidden>
        </SheetHeader>
        <ScrollArea class="grow overflow-auto pr-2">
            <FormContent>
                <slot />
            </FormContent>
        </ScrollArea>
    </SheetContent>
</template>
