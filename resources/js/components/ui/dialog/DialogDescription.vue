<script setup lang="ts">
import { cn } from '@/lib/utils';
import { DialogDescription, type DialogDescriptionProps, useForwardProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<DialogDescriptionProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <DialogDescription
        v-bind="forwardedProps"
        data-slot="dialog-description"
        :class="cn('text-muted-foreground text-sm', props.class)"
    >
        <slot />
    </DialogDescription>
</template>
