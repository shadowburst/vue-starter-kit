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
                'text-foreground underline decoration-muted-foreground underline-offset-4 transition-colors duration-300 ease-out hover:!decoration-current',
                props.class,
            )
        "
    >
        <slot />
    </Link>
</template>
