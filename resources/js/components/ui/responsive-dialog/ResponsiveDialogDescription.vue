<template>
    <DialogDescription v-if="isDesktop">
        <slot />
    </DialogDescription>
    <DrawerDescription v-else>
        <slot />
    </DrawerDescription>
</template>

<script setup lang="ts">
import { DialogDescription } from '@/components/ui/dialog';
import { DrawerDescription } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
