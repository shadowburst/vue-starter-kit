<script lang="ts">
type SmartModalRootContext = {
    isDialog: Ref<boolean>;
};

export const [injectSmartModalRootContext, provideSmartModalRootContext] =
    createContext<SmartModalRootContext>('SmartModalRootContext');
</script>

<script setup lang="ts">
import { Dialog } from '@/components/ui/dialog';
import { Drawer } from '@/components/ui/drawer';
import { useTailwindBreakpoints } from '@/composables';
import { createContext, DialogRootEmits, DialogRootProps, useForwardPropsEmits } from 'reka-ui';
import { DrawerRootProps } from 'vaul-vue';
import { Ref } from 'vue';

type Props = DialogRootProps & DrawerRootProps;
const props = defineProps<Props>();

type Emits = DialogRootEmits;
const emits = defineEmits<Emits>();

const forwardedDialogProps = useForwardPropsEmits(props as DialogRootProps, emits);
const forwardedDrawerProps = useForwardPropsEmits(props as DrawerRootProps, emits);

const isOpen = defineModel<boolean>('open', {
    default: false,
});

const { sm: isDialog } = useTailwindBreakpoints();

provideSmartModalRootContext({
    isDialog,
});
</script>

<template>
    <Dialog v-if="isDialog" v-bind="forwardedDialogProps" v-model:open="isOpen">
        <slot />
    </Dialog>
    <Drawer v-else v-bind="forwardedDrawerProps" v-model:open="isOpen">
        <slot />
    </Drawer>
</template>
