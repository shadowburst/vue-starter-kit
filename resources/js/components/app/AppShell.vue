<script setup lang="ts">
import AppAlertDialog from '@/components/app/AppAlertDialog.vue';
import AppToaster from '@/components/app/AppToaster.vue';
import { useLocale } from '@/composables';
import { ConfigProvider } from 'reka-ui';

const { locale } = useLocale();
</script>

<template>
    <ConfigProvider :locale>
        <AppAlertDialog>
            <div class="container mx-auto h-full">
                <slot />
            </div>
            <AppToaster />
        </AppAlertDialog>
    </ConfigProvider>
</template>
