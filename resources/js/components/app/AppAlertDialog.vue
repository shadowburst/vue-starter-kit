<script lang="ts">
export type AppAlertDialogVariant = 'default' | 'success' | 'warning' | 'destructive';
export type AppAlertDialogParams = {
    variant: AppAlertDialogVariant;
    title?: string;
    description?: string;
    footnote?: string;
    callback?: () => void;
};

export const [useAlert, provideAppAlertDialog] =
    createContext<(params: Partial<AppAlertDialogParams>) => void>('AppAlertDialog');
</script>

<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { useConfirmDialog } from '@vueuse/core';
import { createContext } from 'reka-ui';
import { ref } from 'vue';

const variant = ref<AppAlertDialogVariant>('default');
const title = ref<string>();
const description = ref<string>();
const footnote = ref<string>();

const { isRevealed, reveal, confirm, cancel, onConfirm } = useConfirmDialog();

function alert(params: Partial<AppAlertDialogParams>) {
    variant.value = params.variant ?? 'default';
    title.value = params.title;
    description.value = params.description;
    footnote.value = params.footnote;
    if (params.callback) {
        onConfirm(params.callback);
    }
    reveal();
}

provideAppAlertDialog(alert);
</script>

<template>
    <AlertDialog v-model:open="isRevealed">
        <slot />
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    {{ title ?? $t(`components.app.alert_dialog.title.${variant}`) }}
                </AlertDialogTitle>
                <AlertDialogDescription v-if="description">
                    {{ description }}
                </AlertDialogDescription>
                <AlertDialogDescription class="text-xs italic" v-if="footnote">
                    {{ footnote }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="cancel()">
                    <CapitalizeText>
                        {{ $t('cancel') }}
                    </CapitalizeText>
                </AlertDialogCancel>
                <Button :variant @click="confirm()">
                    <CapitalizeText>
                        {{ $t('confirm') }}
                    </CapitalizeText>
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
