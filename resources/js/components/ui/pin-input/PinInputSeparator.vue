<script setup lang="ts">
import { Minus } from 'lucide-vue-next';
import { Primitive, type PrimitiveProps, useForwardProps } from 'reka-ui';

const props = defineProps<PrimitiveProps>();
const forwardedProps = useForwardProps(props);
</script>

<template>
    <Primitive v-bind="forwardedProps" data-slot="pin-input-separator">
        <slot>
            <Minus />
        </slot>
    </Primitive>
</template>
