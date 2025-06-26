<script lang="ts">
type ResponsiveTabsRootContext = {
    tabs: Ref<NavItem[]>;
    variant: Ref<ResponsiveTabsVariants['variant']>;
};
export const [injectResponsiveTabsRootContext, provideResponsiveTabsRootContext] =
    createContext<ResponsiveTabsRootContext>('ResponsiveTabsRootContext');
</script>

<script setup lang="ts">
import { Tabs } from '@/components/ui/tabs';
import { NavItem } from '@/types';

import { reactiveOmit } from '@vueuse/core';
import type { TabsRootEmits, TabsRootProps } from 'reka-ui';
import { createContext, useForwardPropsEmits } from 'reka-ui';
import { toRefs, type HTMLAttributes, type Ref } from 'vue';
import { ResponsiveTabsVariants } from '.';

type Props = TabsRootProps & {
    tabs: NavItem[];
    variant?: ResponsiveTabsVariants['variant'];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const emits = defineEmits<TabsRootEmits>();

const delegatedProps = reactiveOmit(props, 'class', 'tabs', 'modelValue');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

const { tabs, variant } = toRefs(props);
provideResponsiveTabsRootContext({
    tabs,
    variant,
});

const model = defineModel<string | number>({
    get: () => tabs.value.findIndex((tab) => tab.isActive),
});
</script>

<template>
    <Tabs v-model="model" v-bind="forwarded">
        <slot />
    </Tabs>
</template>
