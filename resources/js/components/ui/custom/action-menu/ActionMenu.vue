<script lang="ts">
type ActionMenuContext = {
    actions: Ref<ActionItem[]>;
};

export const [injectActionMenuContext, provideActionMenuContext] =
    createContext<ActionMenuContext>('ActionMenuContext');
</script>

<script setup lang="ts">
import { createContext } from 'reka-ui';
import { Ref } from 'vue';
import ActionMenuButtonGroup from './ActionMenuButtonGroup.vue';
import ActionMenuDropdown from './ActionMenuDropdown.vue';
import { ActionItem } from './interface';

type Props = {
    actions: ActionItem[];
    variant?: 'dropdown' | 'buttons';
};
withDefaults(defineProps<Props>(), {
    variant: 'dropdown',
});
</script>

<template>
    <ActionMenuDropdown v-if="variant === 'dropdown'" :actions />
    <ActionMenuButtonGroup v-if="variant === 'buttons'" :actions />
</template>
