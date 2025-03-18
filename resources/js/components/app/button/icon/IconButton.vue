<template>
    <Button v-bind="forwarded" :class="cn('relative', props.class)">
        <IconButtonIcon v-if="icon" :as="icon" />
        <slot />
    </Button>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { useForwardProps } from 'reka-ui';
import { computed } from 'vue';
import IconButtonIcon from './IconButtonIcon.vue';
import { IconButtonProps } from './interface';

const { icon, ...props } = defineProps<IconButtonProps>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;
    return delegated;
});

const forwarded = useForwardProps(delegatedProps);
</script>
