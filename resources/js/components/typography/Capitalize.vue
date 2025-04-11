<script setup lang="ts">
import { Primitive, PrimitiveProps } from 'reka-ui';

type Props = PrimitiveProps;
const { as = 'span', ...props } = defineProps<Props>();
</script>

<template>
    <Primitive class="inline-block first-letter:uppercase" v-bind="props" :as>
        <slot />
    </Primitive>
</template>
