<script setup lang="ts">
import { DialogTitle } from '@/components/ui/dialog';
import { DrawerTitle } from '@/components/ui/drawer';
import { DialogTitleProps, useForwardProps } from 'reka-ui';
import { DrawerTitleProps } from 'vaul-vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogTitleProps & DrawerTitleProps;
const props = defineProps<Props>();

const forwardedDialogProps = useForwardProps(props as DialogTitleProps);
const forwardedDrawerProps = useForwardProps(props as DrawerTitleProps);

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogTitle v-if="isDesktop" v-bind="forwardedDialogProps">
        <slot />
    </DialogTitle>
    <DrawerTitle v-else v-bind="forwardedDrawerProps">
        <slot />
    </DrawerTitle>
</template>
