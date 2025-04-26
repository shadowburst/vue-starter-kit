<script setup lang="ts">
import AppAlertDialog from '@/components/app/AppAlertDialog.vue';
import AppToaster from '@/components/app/AppToaster.vue';
</script>

<template>
    <AppAlertDialog>
        <div class="container-grid h-full gap-y-6 py-6">
            <slot />
        </div>
        <AppToaster />
    </AppAlertDialog>
</template>
