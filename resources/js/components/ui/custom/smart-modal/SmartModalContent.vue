<script setup lang="ts">
import { DialogScrollContent } from '@/components/ui/dialog';
import { DrawerContent } from '@/components/ui/drawer';
import { cn } from '@/lib/utils';
import { DialogContentProps, Slot, useForwardProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogContentProps & {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const forwarded = useForwardProps(props);

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogScrollContent v-if="isDesktop" v-bind="forwarded">
        <Slot :class="cn('grid gap-4', props.class)">
            <slot />
        </Slot>
    </DialogScrollContent>
    <DrawerContent v-else v-bind="forwarded">
        <Slot :class="cn('grid gap-6 p-4', props.class)">
            <slot />
        </Slot>
    </DrawerContent>
</template>
