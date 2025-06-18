<script setup lang="ts">
import AppAlertDialog from '@/components/app/AppAlertDialog.vue';
import AppToaster from '@/components/app/AppToaster.vue';
import { useLocale } from '@/composables';
import { router } from '@inertiajs/vue3';
import { ConfigProvider } from 'reka-ui';
import { onUnmounted } from 'vue';

const { locale } = useLocale();

// Try to focus on element after navigating
onUnmounted(
    router.on('navigate', () => {
        document.querySelector<HTMLElement>('[autofocus]')?.focus();
    }),
);
</script>

<template>
    <ConfigProvider :locale>
        <AppAlertDialog>
            <div class="container mx-auto grid h-full overflow-hidden rounded-xl">
                <slot />
            </div>
            <AppToaster />
        </AppAlertDialog>
    </ConfigProvider>
</template>
