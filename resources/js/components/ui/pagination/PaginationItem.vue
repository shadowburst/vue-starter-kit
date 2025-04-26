<script setup lang="ts">
import { buttonVariants, type ButtonVariants } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { PaginationListItem, type PaginationListItemProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';

const props = withDefaults(
    defineProps<
        PaginationListItemProps & {
            size?: ButtonVariants['size'];
            class?: HTMLAttributes['class'];
            isActive?: boolean;
        }
    >(),
    {
        size: 'icon',
    },
);

const delegatedProps = reactiveOmit(props, 'class', 'size', 'isActive');
</script>

<template>
    <PaginationListItem
        v-bind="delegatedProps"
        data-slot="pagination-item"
        :class="
            cn(
                buttonVariants({
                    variant: isActive ? 'outline' : 'ghost',
                    size,
                }),
                props.class,
            )
        "
    >
        <slot />
    </PaginationListItem>
</template>
