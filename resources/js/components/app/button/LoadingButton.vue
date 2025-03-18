<template>
    <IconButton v-bind="forwarded" :icon="loading ? undefined : icon" :disabled="disabled || loading">
        <IconButtonIcon class="animate-spin" v-if="loading" :as="LoaderCircleIcon" />
        <slot />
    </IconButton>
</template>

<script setup lang="ts">
import { LoaderCircleIcon } from 'lucide-vue-next';
import { useForwardProps } from 'reka-ui';
import { IconButton, IconButtonIcon, type IconButtonProps } from './icon';

type Props = IconButtonProps & {
    loading?: boolean;
};
const { icon, loading = false, disabled, ...props } = defineProps<Props>();

const forwarded = useForwardProps(props);
</script>
