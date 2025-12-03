<script setup lang="ts">
import { DialogDescription } from '@/components/ui/dialog';
import { DrawerDescription } from '@/components/ui/drawer';
import { DialogDescriptionProps, useForwardProps } from 'reka-ui';
import { DrawerDescriptionProps } from 'vaul-vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogDescriptionProps & DrawerDescriptionProps;
const props = defineProps<Props>();

const forwardedDialogProps = useForwardProps(props as DialogDescriptionProps);
const forwardedDrawerProps = useForwardProps(props as DrawerDescriptionProps);

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogDescription v-if="isDesktop" v-bind="forwardedDialogProps">
        <slot />
    </DialogDescription>
    <DrawerDescription v-else v-bind="forwardedDrawerProps">
        <slot />
    </DrawerDescription>
</template>
