<script setup lang="ts">
import { DialogClose } from '@/components/ui/dialog';
import { DrawerClose } from '@/components/ui/drawer';
import { DialogCloseProps, useForwardProps } from 'reka-ui';
import { DrawerCloseProps } from 'vaul-vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogCloseProps & DrawerCloseProps;
const props = defineProps<Props>();

const forwardedDialogProps = useForwardProps(props as DialogCloseProps);
const forwardedDrawerProps = useForwardProps(props as DrawerCloseProps);

const { isDialog } = injectSmartModalRootContext();
</script>

<template>
    <DialogClose v-if="isDialog" v-bind="forwardedDialogProps">
        <slot />
    </DialogClose>
    <DrawerClose v-else v-bind="forwardedDrawerProps">
        <slot />
    </DrawerClose>
</template>
