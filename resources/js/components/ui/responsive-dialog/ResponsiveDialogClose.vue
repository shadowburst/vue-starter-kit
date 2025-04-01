<template>
    <DialogClose v-if="isDesktop">
        <slot />
    </DialogClose>
    <DrawerClose v-else>
        <slot />
    </DrawerClose>
</template>

<script setup lang="ts">
import { DialogClose } from '@/components/ui/dialog';
import { DrawerClose } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
