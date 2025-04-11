<script setup lang="ts">
import { Primitive } from 'reka-ui';
</script>

<template>
    <Primitive class="inline-block first-letter:uppercase" as-child>
        <slot />
    </Primitive>
</template>
