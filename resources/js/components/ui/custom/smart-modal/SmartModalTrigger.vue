<script setup lang="ts">
import { DialogTrigger } from '@/components/ui/dialog';
import { DrawerTrigger } from '@/components/ui/drawer';
import { DialogTriggerProps, useForwardProps } from 'reka-ui';
import { DrawerTriggerProps } from 'vaul-vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = DialogTriggerProps & DrawerTriggerProps;
const props = defineProps<Props>();

const forwardedDialogProps = useForwardProps(props as DialogTriggerProps);
const forwardedDrawerProps = useForwardProps(props as DrawerTriggerProps);

const { isDialog } = injectSmartModalRootContext();
</script>

<template>
    <DialogTrigger v-if="isDialog" v-bind="forwardedDialogProps">
        <slot />
    </DialogTrigger>
    <DrawerTrigger v-else v-bind="forwardedDrawerProps">
        <slot />
    </DrawerTrigger>
</template>
