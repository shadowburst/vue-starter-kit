<script setup lang="ts">
import { cn } from '@/lib/utils';
import { DialogDescription, type DialogDescriptionProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<DialogDescriptionProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <DialogDescription v-bind="delegatedProps" :class="cn('text-muted-foreground text-sm', props.class)">
        <slot />
    </DialogDescription>
</template>
