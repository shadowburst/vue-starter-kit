<script lang="ts" setup>
import { useResponsiveState } from '@/composables';
import { reactiveOmit } from '@vueuse/core';
import { useForwardPropsEmits } from 'reka-ui';
import type { DrawerRootEmits, DrawerRootProps } from 'vaul-vue';
import { DrawerRoot } from 'vaul-vue';
import { computed } from 'vue';

const props = withDefaults(defineProps<Omit<DrawerRootProps, 'fadeFromIndex'>>(), {
    shouldScaleBackground: true,
});

const emits = defineEmits<DrawerRootEmits>();

const deletedProps = reactiveOmit(props, 'direction');
const forwarded = useForwardPropsEmits(deletedProps, emits);

const { isMobile } = useResponsiveState();
const direction = computed(() => props.direction ?? (isMobile.value ? 'bottom' : 'top'));
</script>

<template>
    <DrawerRoot data-slot="drawer" v-bind="forwarded" :direction>
        <slot />
    </DrawerRoot>
</template>
