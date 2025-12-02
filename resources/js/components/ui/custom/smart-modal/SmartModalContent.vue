<script setup lang="ts">
import { DialogScrollContent } from '@/components/ui/dialog';
import { DrawerContent } from '@/components/ui/drawer';
import { DialogContentProps, useForwardProps } from 'reka-ui';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogContentProps;
const props = defineProps<Props>();

const forwarded = useForwardProps(props);

const { isDialog } = injectSmartModalRootContext();
</script>

<template>
    <DialogScrollContent v-if="isDialog" v-bind="forwarded">
        <slot />
    </DialogScrollContent>
    <DrawerContent v-else v-bind="forwarded">
        <slot />
    </DrawerContent>
</template>
