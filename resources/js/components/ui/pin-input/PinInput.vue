<script setup lang="ts" generic="Type extends 'text' | 'number' = 'text'">
import { cn } from '@/lib/utils';
import { PinInputRoot, type PinInputRootEmits, type PinInputRootProps, useForwardPropsEmits } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = withDefaults(defineProps<PinInputRootProps<Type> & { class?: HTMLAttributes['class'] }>(), {
    modelValue: () => [],
});
const emits = defineEmits<PinInputRootEmits>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;
    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <PinInputRoot
        v-bind="forwarded"
        data-slot="pin-input"
        :class="cn('flex items-center gap-2 disabled:cursor-not-allowed has-disabled:opacity-50', props.class)"
    >
        <slot />
    </PinInputRoot>
</template>
