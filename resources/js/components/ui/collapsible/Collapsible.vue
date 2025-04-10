<script setup lang="ts">
import type { CollapsibleRootEmits, CollapsibleRootProps } from 'reka-ui';
import { CollapsibleRoot, useForwardPropsEmits } from 'reka-ui';

const props = defineProps<CollapsibleRootProps>();
const emits = defineEmits<CollapsibleRootEmits>();

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <CollapsibleRoot v-slot="{ open }" v-bind="forwarded" data-slot="collapsible">
        <slot :open="open" />
    </CollapsibleRoot>
</template>
