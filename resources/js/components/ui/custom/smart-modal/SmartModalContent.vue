<script setup lang="ts">
import { DialogScrollContent } from '@/components/ui/dialog';
import { DrawerContent } from '@/components/ui/drawer';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { DialogContentProps, Primitive, useForwardProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogContentProps & {
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    as: 'div',
});

const forwarded = useForwardProps(reactiveOmit(props, 'as', 'asChild', 'class'));

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogScrollContent v-if="isDesktop" v-bind="forwarded">
        <Primitive :as :as-child :class="cn('grid w-full gap-4', props.class)">
            <slot />
        </Primitive>
    </DialogScrollContent>
    <DrawerContent v-else v-bind="forwarded">
        <Primitive :as :as-child :class="cn('grid gap-6 p-4', props.class)">
            <slot />
        </Primitive>
    </DrawerContent>
</template>
