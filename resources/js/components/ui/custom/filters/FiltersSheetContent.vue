<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form, FormContent } from '@/components/ui/custom/form';
import { SectionContent } from '@/components/ui/custom/section';
import { CapitalizeText } from '@/components/ui/custom/typography';
import ScrollArea from '@/components/ui/scroll-area/ScrollArea.vue';
import { SheetContent, SheetDescription, SheetFooter, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { Spinner } from '@/components/ui/spinner';
import { cn } from '@/lib/utils';
import { WhenVisible } from '@inertiajs/vue3';
import { XIcon } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectFiltersSheetRootContext } from './FiltersSheet.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { filters, fields, count, data } = injectFiltersSheetRootContext();
</script>

<template>
    <SheetContent :class="cn('w-full', props.class)">
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
        <ScrollArea class="grow overflow-auto">
            <SectionContent class="px-4!">
                <Form :form="filters">
                    <FormContent>
                        <slot />
                    </FormContent>
                </Form>
            </SectionContent>
        </ScrollArea>
        <SheetFooter>
            <div v-if="fields.length">
                <Button
                    class="w-full disabled:opacity-0"
                    variant="outline"
                    :disabled="count === 0"
                    @click="filters.reset(...fields)"
                >
                    <XIcon />
                    <CapitalizeText>
                        {{ $t('reset') }}
                    </CapitalizeText>
                </Button>
            </div>
        </SheetFooter>
        <WhenVisible v-if="data" :data>
            <template #fallback>
                <div class="absolute inset-0 grid place-items-center">
                    <Spinner class="text-primary mx-auto" />
                </div>
            </template>
        </WhenVisible>
    </SheetContent>
</template>
