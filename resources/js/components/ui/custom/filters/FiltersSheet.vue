<script setup lang="ts">
import { Sheet } from '@/components/ui/sheet';
import { type DialogRootEmits, type DialogRootProps, useForwardPropsEmits } from 'reka-ui';

const props = defineProps<DialogRootProps>();
const emits = defineEmits<DialogRootEmits>();

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <Sheet>
        <slot />
    </Sheet>
</template>
