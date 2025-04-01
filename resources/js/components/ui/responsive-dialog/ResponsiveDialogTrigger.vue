<template>
    <DialogTrigger v-if="isDesktop">
        <slot />
    </DialogTrigger>
    <DrawerTrigger v-else>
        <slot />
    </DrawerTrigger>
</template>

<script setup lang="ts">
import { DialogTrigger } from '@/components/ui/dialog';
import { DrawerTrigger } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';

const isDesktop = useIsDesktop();
</script>
