<script setup lang="ts">
import { cn } from '@/lib/utils';
import { TabsList, type TabsListProps } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<TabsListProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <TabsList
        v-bind="delegatedProps"
        data-slot="tabs-list"
        :class="
            cn(
                'bg-muted text-muted-foreground inline-flex w-fit items-center justify-center rounded-lg p-[3px] [[data-orientation=horizontal]_&]:h-9',
                props.class,
            )
        "
    >
        <slot />
    </TabsList>
</template>
