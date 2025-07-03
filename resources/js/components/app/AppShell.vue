<script setup lang="ts">
import AppAlertDialog from '@/components/app/AppAlertDialog.vue';
import AppToaster from '@/components/app/AppToaster.vue';
import { useAutofocus, useLocale } from '@/composables';
import { router } from '@inertiajs/vue3';
import { ConfigProvider } from 'reka-ui';
import { onUnmounted } from 'vue';

const { locale } = useLocale();
useAutofocus();
onUnmounted(router.on('navigate', () => router.flushAll()));
</script>

<template>
    <ConfigProvider :locale>
        <AppAlertDialog>
            <div class="container grid h-full overflow-hidden rounded-xl max-xl:mx-auto">
                <slot />
            </div>
            <AppToaster />
        </AppAlertDialog>
    </ConfigProvider>
</template>
