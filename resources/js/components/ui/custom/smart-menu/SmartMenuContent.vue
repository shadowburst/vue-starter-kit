<script setup lang="ts">
import { DrawerContent } from '@/components/ui/drawer';
import { DropdownMenuContent } from '@/components/ui/dropdown-menu';
import { DropdownMenuContentProps, useForwardProps } from 'reka-ui';
import { injectSmartMenuContext } from './SmartMenu.vue';

type Props = DropdownMenuContentProps;
const props = defineProps<Props>();

const forwarded = useForwardProps(props);

const { isDesktop } = injectSmartMenuContext();
</script>

<template>
    <DropdownMenuContent v-if="isDesktop" v-bind="forwarded">
        <slot />
    </DropdownMenuContent>
    <DrawerContent v-else class="space-y-1 px-2 pb-1.5">
        <slot />
    </DrawerContent>
</template>
