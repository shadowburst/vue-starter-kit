<script setup lang="ts">
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import type { TabsRootEmits, TabsRootProps } from 'reka-ui';
import { TabsRoot, useForwardPropsEmits } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

const props = defineProps<TabsRootProps & { class?: HTMLAttributes['class'] }>();
const emits = defineEmits<TabsRootEmits>();

const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <TabsRoot v-bind="forwarded" data-slot="tabs" :class="cn('flex flex-col gap-2', props.class)">
        <slot />
    </TabsRoot>
</template>
