<template>
    <AlertDialog v-model:open="open">
        <slot />

        <AlertDialogContent>
            <AlertDialogHeader v-if="hasHeader">
                <AlertDialogTitle>
                    {{ state.title ?? $t(`components.app.alert_dialog.title.${state.type}`) }}
                </AlertDialogTitle>
                <AlertDialogDescription v-if="state.description">
                    {{ state.description }}
                </AlertDialogDescription>
                <AlertDialogDescription class="text-xs italic" v-if="state.footnote">
                    {{ state.footnote }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>
                    {{ $t('cancel') }}
                </AlertDialogCancel>
                <AlertDialogAction @click="state.callback?.()">
                    {{ $t('confirm') }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script lang="ts" setup>
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
import { AppAlertDialogState, provideAppAlertDialog } from '@/composables';
import { computed, reactive } from 'vue';

const open = defineModel<boolean>('open', {
    default: false,
});

const state = reactive<AppAlertDialogState>({ type: 'info' });

const hasHeader = computed((): boolean => !!(state.title || state.description));

function alert(options: Partial<AppAlertDialogState>) {
    state.type = options.type ?? 'info';
    state.title = options.title;
    state.description = options.description;
    state.footnote = options.footnote;
    state.callback = options.callback;
    open.value = true;
}

provideAppAlertDialog(alert);
</script>
