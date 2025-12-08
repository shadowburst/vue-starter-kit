<script setup lang="ts">
import { DialogFooter } from '@/components/ui/dialog';
import { DrawerFooter } from '@/components/ui/drawer';
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogFooter v-if="isDesktop" :class="props.class">
        <slot />
    </DialogFooter>
    <DrawerFooter v-else :class="cn('flex-col-reverse p-0', props.class)">
        <slot />
    </DrawerFooter>
</template>
