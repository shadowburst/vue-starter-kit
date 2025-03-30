<script setup lang="ts">
import AppAlertDialog from '@/components/app/AppAlertDialog.vue';
import AppToaster from '@/components/app/AppToaster.vue';
</script>

<template>
    <AppAlertDialog>
        <slot />
        <AppToaster />
    </AppAlertDialog>
</template>
