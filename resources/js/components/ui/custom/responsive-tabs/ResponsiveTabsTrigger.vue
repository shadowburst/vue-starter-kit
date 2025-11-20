<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    Drawer,
    DrawerContent,
    DrawerDescription,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer';
import { TabsList, TabsTrigger } from '@/components/ui/tabs';
import { useTailwindBreakpoints } from '@/composables';
import { cn } from '@/lib/utils';
import { injectTabsRootContext, VisuallyHidden } from 'reka-ui';
import { HTMLAttributes, ref } from 'vue';
import { responsiveTabsVariants } from '.';
import { injectResponsiveTabsRootContext } from './ResponsiveTabs.vue';

type Props = {
    align?: 'start' | 'center' | 'end';
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    align: 'center',
});

const { activeTab, tabs, variant } = injectResponsiveTabsRootContext();
const { orientation } = injectTabsRootContext();

const { sm } = useTailwindBreakpoints();

const open = ref(false);
</script>

<template>
    <TabsList
        v-if="sm"
        :class="
            cn(
                'w-full',
                { 'grid h-auto grid-cols-1': orientation === 'vertical', 'bg-transparent': variant === 'ghost' },
                props.class,
            )
        "
    >
        <TabsTrigger
            v-for="({ href, title, icon, options = {} }, index) in tabs"
            :key="index"
            :value="index"
            as-child
            :class="cn(responsiveTabsVariants({ variant }), { 'justify-start': align === 'start' })"
        >
            <InertiaLink v-bind="options ?? {}" :href="href">
                <component v-if="icon" :is="icon" />
                <CapitalizeText>
                    {{ title }}
                </CapitalizeText>
            </InertiaLink>
        </TabsTrigger>
    </TabsList>
    <Drawer v-else v-model:open="open">
        <DrawerTrigger v-if="activeTab" as-child>
            <Button variant="outline">
                <component v-if="activeTab.icon" :is="activeTab.icon" />
                <CapitalizeText>
                    {{ activeTab.title }}
                </CapitalizeText>
            </Button>
        </DrawerTrigger>
        <DrawerContent class="gap-1 p-1">
            <VisuallyHidden>
                <DrawerHeader>
                    <DrawerTitle> </DrawerTitle>
                    <DrawerDescription> </DrawerDescription>
                </DrawerHeader>
            </VisuallyHidden>
            <Button
                v-for="tab in tabs"
                :key="tab.href"
                variant="ghost"
                size="lg"
                as-child
                :class="{ 'bg-muted': tab.isActive }"
            >
                <InertiaLink v-bind="tab.options" :href="tab.href" @click="open = false">
                    <component v-if="tab.icon" :is="tab.icon" />
                    <CapitalizeText>
                        {{ tab.title }}
                    </CapitalizeText>
                </InertiaLink>
            </Button>
        </DrawerContent>
    </Drawer>
</template>
