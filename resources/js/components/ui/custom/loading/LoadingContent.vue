<script setup lang="ts">
import { reactiveOmit } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';
import { LoadingVariants } from '.';
import LoadingIcon from './LoadingIcon.vue';

type Props = {
    loading?: boolean;
    size?: LoadingVariants['size'];
    variant?: LoadingVariants['variant'];
};
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'loading');
const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <slot v-if="!loading" />
    <div class="grid place-items-center" v-else>
        <slot name="fallback">
            <LoadingIcon v-bind="forwarded" />
        </slot>
    </div>
</template>
