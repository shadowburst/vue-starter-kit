<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ButtonProps } from '@/components/ui/button/interface';
import { DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { DropdownMenuItemProps, useForwardProps } from 'reka-ui';
import { injectSmartMenuContext } from './SmartMenu.vue';

type Props = DropdownMenuItemProps & ButtonProps;
const props = defineProps<Props>();

const forwardedDropdownMenuProps = useForwardProps(props as DropdownMenuItemProps);
const forwardedButtonProps = useForwardProps(props as ButtonProps);

const { isDesktop } = injectSmartMenuContext();
</script>

<template>
    <DropdownMenuItem v-if="isDesktop" v-bind="forwardedDropdownMenuProps">
        <slot />
    </DropdownMenuItem>
    <Button v-else variant="ghost" size="lg" v-bind="forwardedButtonProps">
        <slot />
    </Button>
</template>
