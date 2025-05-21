<template>
    <DialogScrollContent v-if="isDesktop">
        <slot />
    </DialogScrollContent>
    <DrawerContent v-else>
        <slot />
    </DrawerContent>
</template>

<script setup lang="ts">
import { DialogScrollContent } from '@/components/ui/dialog';
import { DrawerContent } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
