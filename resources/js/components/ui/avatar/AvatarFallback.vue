<script setup lang="ts">
import { cn } from '@/lib/utils';
import { AvatarFallback, type AvatarFallbackProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<AvatarFallbackProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <AvatarFallback
        v-bind="delegatedProps"
        data-slot="avatar-fallback"
        :class="cn('flex size-full items-center justify-center rounded-full', props.class)"
    >
        <slot />
    </AvatarFallback>
</template>
