<script lang="ts">
type ResponsiveTabsRootContext = {
    tabs: Ref<NavItem[]>;
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

type Props = TabsRootProps & {
    tabs: NavItem[];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const emits = defineEmits<TabsRootEmits>();

const delegatedProps = reactiveOmit(props, 'class', 'tabs', 'modelValue');
const forwarded = useForwardPropsEmits(delegatedProps, emits);

const { tabs } = toRefs(props);
provideResponsiveTabsRootContext({
    tabs,
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
