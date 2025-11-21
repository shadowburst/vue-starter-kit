<script lang="ts">
type AlertDrawerVariant = 'default' | 'destructive';
type AlertDrawerState = {
    variant: AlertDrawerVariant;
    title?: string;
    description?: string;
    footnote?: string;
    callback?: () => void;
};

type AlertDrawerContext = {
    alert: (state: Partial<AlertDrawerState>) => void;
};

export const [injectAlertDrawerContext, provideAlertDrawerContext] = createContext<AlertDrawerContext>('AlertDrawer');
</script>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
} from '@/components/ui/drawer';
import { createContext } from 'reka-ui';
import { ref } from 'vue';

const open = ref<boolean>(false);

const variant = ref<AlertDrawerState['variant']>('default');
const title = ref<AlertDrawerState['title']>();
const description = ref<AlertDrawerState['description']>();
const footnote = ref<AlertDrawerState['footnote']>();
const callback = ref<AlertDrawerState['callback']>();

function alert(state: Partial<AlertDrawerState>) {
    variant.value = state.variant ?? 'default';
    title.value = state.title;
    description.value = state.description;
    footnote.value = state.footnote;
    callback.value = state.callback;
    open.value = true;
}

provideAlertDrawerContext({
    alert,
});
</script>

<template>
    <Drawer v-model:open="open">
        <slot />
        <DrawerContent>
            <div class="mx-auto sm:max-w-fit">
                <DrawerHeader>
                    <DrawerTitle>
                        {{ title ?? $t(`components.ui.custom.alert_drawer.title.${variant}`) }}
                    </DrawerTitle>
                    <DrawerDescription v-if="description">
                        {{ description }}
                    </DrawerDescription>
                    <DrawerDescription class="text-xs italic" v-if="footnote">
                        {{ footnote }}
                    </DrawerDescription>
                </DrawerHeader>
                <DrawerFooter>
                    <Button v-if="callback" :variant as-child @click="callback()">
                        <DrawerAction>
                            <CapitalizeText>
                                {{ $t('confirm') }}
                            </CapitalizeText>
                        </DrawerAction>
                    </Button>
                    <DrawerClose as-child>
                        <Button variant="ghost">
                            <CapitalizeText>
                                {{ $t('cancel') }}
                            </CapitalizeText>
                        </Button>
                    </DrawerClose>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>
