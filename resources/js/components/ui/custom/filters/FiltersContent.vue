<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { FormContent, injectFormContext } from '@/components/ui/custom/form';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
} from '@/components/ui/drawer';
import { ScrollArea } from '@/components/ui/scroll-area';
import { XIcon } from 'lucide-vue-next';
import { VisuallyHidden } from 'reka-ui';

const { form } = injectFormContext();
</script>

<template>
    <DrawerContent class="flex h-dvh flex-col">
        <DrawerHeader>
            <div class="flex items-center gap-4">
                <DrawerTitle>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.filters.content.title') }}
                    </CapitalizeText>
                </DrawerTitle>
                <DrawerClose as-child class="ml-auto max-sm:hidden">
                    <Button variant="outline" size="icon-sm">
                        <XIcon />
                    </Button>
                </DrawerClose>
            </div>
            <VisuallyHidden>
                <DrawerDescription>
                    <CapitalizeText>
                        {{ $t('components.ui.custom.filters.content.description') }}
                    </CapitalizeText>
                </DrawerDescription>
            </VisuallyHidden>
        </DrawerHeader>
        <ScrollArea class="flex-1">
            <FormContent class="m-0.5 px-4">
                <slot />
            </FormContent>
        </ScrollArea>
        <DrawerFooter>
            <Button variant="outline" class="w-full" @click="form.reset()">
                <CapitalizeText>
                    {{ $t('components.ui.custom.filters.content.reset') }}
                </CapitalizeText>
            </Button>
        </DrawerFooter>
    </DrawerContent>
</template>
