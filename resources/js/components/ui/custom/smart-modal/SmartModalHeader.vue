<script setup lang="ts">
import { DialogHeader } from '@/components/ui/dialog';
import { DrawerHeader } from '@/components/ui/drawer';
import { cn } from '@/lib/utils';
import { useForwardProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { injectSmartModalRootContext } from './SmartModal.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const forwarded = useForwardProps(props);

const { isDesktop } = injectSmartModalRootContext();
</script>

<template>
    <DialogHeader v-if="isDesktop" v-bind="forwarded">
        <slot />
    </DialogHeader>
    <DrawerHeader v-else :class="cn('p-0', props.class)">
        <slot />
    </DrawerHeader>
</template>
