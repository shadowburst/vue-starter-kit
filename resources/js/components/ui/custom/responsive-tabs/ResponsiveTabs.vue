<script lang="ts">
type ResponsiveTabsRootContext = {
    activeTab: Ref<NavItemHref | undefined>;
    tabs: Ref<NavItemHref[]>;
    variant: Ref<ResponsiveTabsVariants['variant']>;
};
export const [injectResponsiveTabsRootContext, provideResponsiveTabsRootContext] =
    createContext<ResponsiveTabsRootContext>('ResponsiveTabsRootContext');
</script>

<script setup lang="ts">
import { Tabs } from '@/components/ui/tabs';
import { NavItemHref } from '@/types';

import { reactiveOmit } from '@vueuse/core';
import type { TabsRootEmits, TabsRootProps } from 'reka-ui';
import { createContext, useForwardPropsEmits } from 'reka-ui';
import { computed, toRefs, type HTMLAttributes, type Ref } from 'vue';
import { ResponsiveTabsVariants } from '.';

type Props = TabsRootProps & {
    tabs: NavItemHref[];
    variant?: ResponsiveTabsVariants['variant'];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const emits = defineEmits<TabsRootEmits>();

const delegatedProps = reactiveOmit(props, 'class', 'tabs', 'modelValue');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

const { tabs, variant } = toRefs(props);
const activeTab = computed(() => tabs.value.find((tab) => tab.isActive));
provideResponsiveTabsRootContext({
    activeTab,
    tabs,
    variant,
});

const model = defineModel<number>({
    get: () => tabs.value.findIndex((tab) => tab.isActive),
});
</script>

<template>
    <Tabs v-model="model" v-bind="forwarded">
        <slot />
    </Tabs>
</template>
