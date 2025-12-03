<script setup lang="ts">
import { DrawerTrigger } from '@/components/ui/drawer';
import { DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { DropdownMenuTriggerProps, useForwardProps } from 'reka-ui';
import { DrawerTriggerProps } from 'vaul-vue';
import { injectSmartMenuContext } from './SmartMenu.vue';

type Props = DropdownMenuTriggerProps & DrawerTriggerProps;
const props = defineProps<Props>();

const forwardedDropdownMenuProps = useForwardProps(props as DropdownMenuTriggerProps);
const forwardedDrawerProps = useForwardProps(props as DrawerTriggerProps);

const { isDesktop } = injectSmartMenuContext();
</script>

<template>
    <DropdownMenuTrigger v-if="isDesktop" v-bind="forwardedDropdownMenuProps">
        <slot />
    </DropdownMenuTrigger>
    <DrawerTrigger v-else v-bind="forwardedDrawerProps">
        <slot />
    </DrawerTrigger>
</template>
