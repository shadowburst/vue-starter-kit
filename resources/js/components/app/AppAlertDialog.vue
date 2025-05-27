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
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { createContext } from 'reka-ui';
import { ref } from 'vue';

const open = ref<boolean>(false);
const variant = ref<AppAlertDialogVariant>('default');
const title = ref<string>();
const description = ref<string>();
const footnote = ref<string>();
const callback = ref<() => void>();

function alert(params: Partial<AppAlertDialogParams>) {
    variant.value = params.variant ?? 'default';
    title.value = params.title;
    description.value = params.description;
    footnote.value = params.footnote;
    callback.value = params.callback;
    open.value = true;
}

provideAppAlertDialog(alert);
</script>

<template>
    <AlertDialog v-model:open="open">
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
                <AlertDialogCancel>
                    <CapitalizeText>
                        {{ $t('cancel') }}
                    </CapitalizeText>
                </AlertDialogCancel>
                <Button v-if="callback" :variant as-child @click="callback()">
                    <AlertDialogAction>
                        <CapitalizeText>
                            {{ $t('confirm') }}
                        </CapitalizeText>
                    </AlertDialogAction>
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
