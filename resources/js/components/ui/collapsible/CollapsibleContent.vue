<script setup lang="ts">
import { cn } from '@/lib/utils';
import { CollapsibleContent, type CollapsibleContentProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';

type Props = CollapsibleContentProps & {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <CollapsibleContent
        v-bind="props"
        data-slot="collapsible-content"
        :class="
            cn(
                'data-[state=closed]:animate-collapsible-up data-[state=open]:animate-collapsible-down overflow-hidden transition-all',
                props.class,
            )
        "
    >
        <slot />
    </CollapsibleContent>
</template>
