<script setup lang="ts">
import { DialogFooter } from '@/components/ui/dialog';
import { DrawerFooter } from '@/components/ui/drawer';
import { useForwardProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const forwarded = useForwardProps(props);

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogFooter v-if="isDesktop" v-bind="forwarded">
        <slot />
    </DialogFooter>
    <DrawerFooter v-else v-bind="forwarded">
        <slot />
    </DrawerFooter>
</template>
