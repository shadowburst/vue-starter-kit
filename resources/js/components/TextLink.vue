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
                'text-foreground decoration-muted-foreground ring-offset-background focus-visible:ring-ring rounded-sm underline underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-hidden',
                props.class,
            )
        "
    >
        <slot />
    </Link>
</template>
