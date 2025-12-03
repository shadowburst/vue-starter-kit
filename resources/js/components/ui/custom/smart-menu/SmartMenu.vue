<script lang="ts">
type SmartMenuContext = {
    isDesktop: Ref<boolean>;
};

export const [injectSmartMenuContext, provideSmartMenuContext] = createContext<SmartMenuContext>('SmartMenuContext');
</script>

<script setup lang="ts">
import { Drawer } from '@/components/ui/drawer';
import { DropdownMenu } from '@/components/ui/dropdown-menu';
import { useTailwindBreakpoints } from '@/composables';
import {
    createContext,
    DialogRootEmits,
    DropdownMenuRootEmits,
    DropdownMenuRootProps,
    useForwardPropsEmits,
} from 'reka-ui';
import { DrawerRootProps } from 'vaul-vue';
import { Ref } from 'vue';

type Props = DropdownMenuRootProps & DrawerRootProps;
const props = defineProps<Props>();

type Emits = DropdownMenuRootEmits & DialogRootEmits;
const emits = defineEmits<Emits>();

const forwardedDropdownMenuProps = useForwardPropsEmits(props as DropdownMenuRootProps, emits);
const forwardedDrawerProps = useForwardPropsEmits(props as DrawerRootProps, emits);

const isOpen = defineModel<boolean>('open', {
    default: false,
});

const { sm: isDesktop } = useTailwindBreakpoints();

provideSmartMenuContext({
    isDesktop,
});
</script>

<template>
    <DropdownMenu v-if="isDesktop" v-bind="forwardedDropdownMenuProps" v-model:open="isOpen">
        <slot />
    </DropdownMenu>
    <Drawer v-else v-bind="forwardedDrawerProps" v-model:open="isOpen">
        <slot />
    </Drawer>
</template>
