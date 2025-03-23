<script setup lang="ts">
import { cn } from '@/lib/utils';
import { InertiaLinkProps, Link } from '@inertiajs/vue3';
import { useForwardProps } from 'reka-ui';
import { computed, HTMLAttributes } from 'vue';

type Props = InertiaLinkProps & {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;
    return delegated;
});

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
    <Link
        v-bind="forwarded"
        :class="
            cn(
                'rounded-sm text-foreground underline decoration-muted-foreground underline-offset-4 ring-offset-background transition-colors duration-300 ease-out hover:!decoration-current focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
                props.class,
            )
        "
    >
        <slot />
    </Link>
</template>
