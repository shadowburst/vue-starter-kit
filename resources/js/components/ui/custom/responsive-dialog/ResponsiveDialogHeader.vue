<template>
    <DialogHeader v-if="isDesktop">
        <slot />
    </DialogHeader>
    <DrawerHeader v-else>
        <slot />
    </DrawerHeader>
</template>

<script setup lang="ts">
import { DialogHeader } from '@/components/ui/dialog';
import { DrawerHeader } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
