<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form, FormContent } from '@/components/ui/custom/form';
import { LoadingIcon } from '@/components/ui/custom/loading';
import { SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import ScrollArea from '@/components/ui/scroll-area/ScrollArea.vue';
import {
    SheetClose,
    SheetContent,
    SheetContentProps,
    SheetDescription,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { cn } from '@/lib/utils';
import { WhenVisible } from '@inertiajs/vue3';
import { reactiveOmit } from '@vueuse/core';
import { XIcon } from 'lucide-vue-next';
import { useForwardProps, VisuallyHidden } from 'reka-ui';
import { injectFiltersSheetRootContext } from './FiltersSheet.vue';

const props = defineProps<SheetContentProps>();
const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardProps(delegatedProps);

const { filters, fields, count, data } = injectFiltersSheetRootContext();
</script>

<template>
    <SheetContent v-bind="forwarded" :class="cn('w-full', props.class)">
        <SheetHeader>
            <div v-if="fields.length">
                <SheetClose as-child>
                    <Button
                        class="disabled:invisible"
                        variant="outline"
                        :disabled="count === 0"
                        @click="filters.reset(...fields)"
                    >
                        <XIcon />
                        <CapitalizeText>
                            {{ $t('reset') }}
                        </CapitalizeText>
                    </Button>
                </SheetClose>
            </div>
            <VisuallyHidden>
                <SheetTitle>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.filters.sheet.title') }}
                    </CapitalizeText>
                </SheetTitle>
                <SheetDescription>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.filters.sheet.description') }}
                    </CapitalizeText>
                </SheetDescription>
            </VisuallyHidden>
        </SheetHeader>
        <ScrollArea class="grow overflow-auto">
            <SectionContent class="px-4!">
                <Form :form="filters">
                    <FormContent>
                        <slot />
                    </FormContent>
                </Form>
            </SectionContent>
        </ScrollArea>
        <WhenVisible v-if="data" :data>
            <template #fallback>
                <div class="absolute inset-0 grid place-items-center">
                    <LoadingIcon class="mx-auto" variant="primary" />
                </div>
            </template>
        </WhenVisible>
    </SheetContent>
</template>
