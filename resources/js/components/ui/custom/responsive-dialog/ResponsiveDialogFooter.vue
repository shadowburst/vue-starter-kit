<template>
    <DialogFooter v-if="isDesktop">
        <slot />
    </DialogFooter>
    <DrawerFooter v-else>
        <slot />
    </DrawerFooter>
</template>

<script setup lang="ts">
import { DialogFooter } from '@/components/ui/dialog';
import { DrawerFooter } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
