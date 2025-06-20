<script setup lang="ts">
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { useIsDesktop } from '@/composables';
import { cn } from '@/lib/utils';
import { injectTabsRootContext } from 'reka-ui';
import { HTMLAttributes, ref } from 'vue';
import { injectResponsiveTabsRootContext } from './ResponsiveTabs.vue';

type Props = {
    align?: 'start' | 'center' | 'end';
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    align: 'center',
});

const { tabs } = injectResponsiveTabsRootContext();
const { modelValue, orientation } = injectTabsRootContext();

const isDesktop = useIsDesktop();

const open = ref(false);
</script>

<template>
    <TabsList v-if="isDesktop" :class="cn('w-full', { 'grid grid-cols-1': orientation === 'vertical' }, props.class)">
        <TabsTrigger v-for="({ href, title, icon, options = {} }, index) in tabs" :key="index" :value="index" as-child>
            <InertiaLink v-bind="options ?? {}" :href="href" :class="{ 'justify-start': align === 'start' }">
                <component v-if="icon" :is="icon" />
                <CapitalizeText>
                    {{ title }}
                </CapitalizeText>
            </InertiaLink>
        </TabsTrigger>
    </TabsList>
    <Select v-else v-model="modelValue" v-model:open="open">
        <SelectTrigger :class="cn('w-full', props.class)">
            <TabsContent v-for="(tab, index) in tabs" :key="tab.href" :value="index" as-child>
                <SelectValue class="flex items-center gap-2">
                    <component v-if="tab.icon" :is="tab.icon" />
                    <CapitalizeText>
                        {{ tab.title }}
                    </CapitalizeText>
                </SelectValue>
            </TabsContent>
        </SelectTrigger>
        <SelectContent>
            <InertiaLink
                v-for="({ href, title, icon, options = {} }, index) in tabs"
                v-bind="options"
                :key="href"
                :href="href"
                @click="
                    () => {
                        modelValue = index;
                        open = false;
                    }
                "
            >
                <SelectItem :value="index" @select.prevent>
                    <component v-if="icon" :is="icon" />
                    <CapitalizeText>
                        {{ title }}
                    </CapitalizeText>
                </SelectItem>
            </InertiaLink>
        </SelectContent>
    </Select>
</template>
