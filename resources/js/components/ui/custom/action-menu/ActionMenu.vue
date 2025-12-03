<script lang="ts">
type ActionMenuContext<T> = {
    actions: Ref<ActionItem<T>[]>;
    payload: Ref<T>;
};

export function injectActionMenuContext<TData>(fallback?: ActionMenuContext<TData>): ActionMenuContext<TData> {
    const context = inject('ActionMenuContext', fallback);

    if (!context) {
        throw new Error('Injection `ActionMenuContext` not found. Component must be used within an `ActionMenu`');
    }

    return context;
}
export function provideActionMenuContext<TData>(contextValue: ActionMenuContext<TData>) {
    return provide('ActionMenuContext', contextValue);
}
</script>

<script setup lang="ts" generic="T">
import { computed, inject, provide, Ref } from 'vue';
import ActionMenuDropdown from './ActionMenuDropdown.vue';
import { ActionItem } from './interface';

type Props = {
    actions: ActionItem<T>[];
    payload: T;
    variant?: 'full' | 'icon' | 'dropdown';
};
const props = withDefaults(defineProps<Props>(), {
    variant: 'dropdown',
});

provideActionMenuContext({
    actions: computed(() => props.actions),
    payload: computed(() => props.payload),
});
</script>

<template>
    <ActionMenuDropdown v-if="variant === 'dropdown'" />
</template>
