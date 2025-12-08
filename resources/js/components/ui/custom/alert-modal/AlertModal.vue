<script lang="ts">
type AlertModalState = {
    variant: 'default' | 'destructive';
    title?: string;
    description?: string;
    footnote?: string;
    callback?: () => void;
};

type AlertModalContext = {
    alert: (state: Partial<AlertModalState>) => void;
};

export const [injectAlertModalContext, provideAlertModalContext] = createContext<AlertModalContext>('AlertModal');
</script>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    SmartModal,
    SmartModalClose,
    SmartModalContent,
    SmartModalDescription,
    SmartModalFooter,
    SmartModalHeader,
    SmartModalTitle,
} from '@/components/ui/custom/smart-modal';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { createContext } from 'reka-ui';
import { reactive, ref } from 'vue';

const open = ref<boolean>(false);

const state = reactive<AlertModalState>({
    variant: 'default',
});

function alert(options: Partial<AlertModalState>) {
    Object.assign(state, { variant: 'default', ...options });
    open.value = true;
}

provideAlertModalContext({
    alert,
});
</script>

<template>
    <SmartModal v-model:open="open">
        <slot />
        <SmartModalContent>
            <div class="mx-auto sm:max-w-fit">
                <SmartModalHeader>
                    <SmartModalTitle>
                        {{ state.title ?? $t(`components.ui.custom.alert_modal.title.${state.variant}`) }}
                    </SmartModalTitle>
                    <SmartModalDescription v-if="state.description">
                        {{ state.description }}
                    </SmartModalDescription>
                    <SmartModalDescription class="text-xs italic" v-if="state.footnote">
                        {{ state.footnote }}
                    </SmartModalDescription>
                </SmartModalHeader>
                <SmartModalFooter>
                    <SmartModalClose as-child>
                        <Button v-if="state.callback" :variant="state.variant" @click="state.callback()">
                            <CapitalizeText>
                                {{ $t('confirm') }}
                            </CapitalizeText>
                        </Button>
                    </SmartModalClose>
                    <SmartModalClose as-child>
                        <Button variant="ghost">
                            <CapitalizeText>
                                {{ $t('cancel') }}
                            </CapitalizeText>
                        </Button>
                    </SmartModalClose>
                </SmartModalFooter>
            </div>
        </SmartModalContent>
    </SmartModal>
</template>
