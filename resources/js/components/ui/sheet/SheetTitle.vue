<script setup lang="ts">
import { cn } from '@/lib/utils';
import { DialogTitle, type DialogTitleProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<DialogTitleProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <DialogTitle
        v-bind="delegatedProps"
        data-slot="sheet-title"
        :class="cn('text-foreground font-semibold', props.class)"
    >
        <slot />
    </DialogTitle>
</template>
