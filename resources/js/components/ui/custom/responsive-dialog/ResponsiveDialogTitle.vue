<template>
    <DialogTitle v-if="isDesktop">
        <slot />
    </DialogTitle>
    <DrawerTitle v-else>
        <slot />
    </DrawerTitle>
</template>

<script setup lang="ts">
import { DialogTitle } from '@/components/ui/dialog';
import { DrawerTitle } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
