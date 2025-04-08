<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Primitive, type PrimitiveProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import { type SidebarMenuButtonVariants, sidebarMenuButtonVariants } from '.';

export interface SidebarMenuButtonProps extends PrimitiveProps {
    variant?: SidebarMenuButtonVariants['variant'];
    size?: SidebarMenuButtonVariants['size'];
    isActive?: boolean;
    class?: HTMLAttributes['class'];
}

const props = withDefaults(defineProps<SidebarMenuButtonProps>(), {
    as: 'button',
    variant: 'default',
    size: 'default',
});
</script>

<template>
    <Primitive
        v-bind="$attrs"
        data-slot="sidebar-menu-button"
        data-sidebar="menu-button"
        :data-size="size"
        :data-active="isActive"
        :class="cn(sidebarMenuButtonVariants({ variant, size }), props.class)"
        :as="as"
        :as-child="asChild"
    >
        <slot />
    </Primitive>
</template>
