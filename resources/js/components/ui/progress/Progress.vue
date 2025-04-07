<script setup lang="ts">
import { cn } from '@/lib/utils';
import { ProgressIndicator, ProgressRoot, type ProgressRootProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = withDefaults(defineProps<ProgressRootProps & { class?: HTMLAttributes['class'] }>(), {
    modelValue: 0,
});

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <ProgressRoot
        v-bind="delegatedProps"
        data-slot="progress"
        :class="cn('bg-primary/20 relative h-2 w-full overflow-hidden rounded-full', props.class)"
    >
        <ProgressIndicator
            class="bg-primary h-full w-full flex-1 transition-all"
            data-slot="progress-indicator"
            :style="`transform: translateX(-${100 - (props.modelValue ?? 0)}%);`"
        />
    </ProgressRoot>
</template>
