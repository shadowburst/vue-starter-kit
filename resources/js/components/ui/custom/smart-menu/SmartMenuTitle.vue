<script setup lang="ts">
import { DrawerHeader, DrawerTitle } from '@/components/ui/drawer';
import { DropdownMenuLabel } from '@/components/ui/dropdown-menu';
import { DropdownMenuLabelProps, useForwardProps } from 'reka-ui';
import { DrawerTitleProps } from 'vaul-vue';
import { injectSmartMenuContext } from './SmartMenu.vue';

type Props = DropdownMenuLabelProps & DrawerTitleProps;
const props = defineProps<Props>();

const forwardedDropdownMenuProps = useForwardProps(props as DropdownMenuLabelProps);
const forwardedDrawerProps = useForwardProps(props as DrawerTitleProps);

const { isDesktop } = injectSmartMenuContext();
</script>

<template>
    <DropdownMenuLabel v-if="isDesktop" v-bind="forwardedDropdownMenuProps">
        <slot />
    </DropdownMenuLabel>
    <DrawerHeader v-else v-bind="forwardedDrawerProps">
        <DrawerTitle>
            <slot />
        </DrawerTitle>
    </DrawerHeader>
</template>
