<script setup lang="ts">
import { CollapsibleContent, type CollapsibleContentProps } from 'reka-ui';

const props = defineProps<CollapsibleContentProps>();
</script>

<template>
    <CollapsibleContent v-bind="props" data-slot="collapsible-content">
        <slot />
    </CollapsibleContent>
</template>
