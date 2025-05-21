<template>
    <Dialog v-if="isDesktop" v-model:open="isOpen">
        <slot />
    </Dialog>
    <Drawer v-else v-model:open="isOpen">
        <slot />
    </Drawer>
</template>

<script setup lang="ts">
import { Dialog } from '@/components/ui/dialog';
import { Drawer } from '@/components/ui/drawer';
import { useIsDesktop } from '@/composables';
import { ref } from 'vue';

const isDesktop = useIsDesktop();

const isOpen = ref(false);
</script>
