<script setup lang="ts">
import { SmartMenu, SmartMenuContent } from '@/components/ui/custom/smart-menu';
import { cn } from '@/lib/utils';
import { computed, HTMLAttributes } from 'vue';
import ActionMenuButton from './ActionMenuButton.vue';
import ActionMenuDropdownItem from './ActionMenuDropdownItem.vue';
import { ActionItem } from './interface';

type Props = {
    actions: ActionItem[];
    buttons?: boolean | number;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const buttonActions = computed((): ActionItem[] => {
    if (!props.buttons) {
        return [];
    }
    if (props.buttons === true) {
        return props.actions;
    }
    return props.actions.slice(0, props.buttons);
});
const dropdownActions = computed(() => props.actions.slice(buttonActions.value.length));
</script>

<template>
    <div :class="cn('flex items-center gap-2', props.class)">
        <ActionMenuButton v-for="(action, index) in buttonActions" :key="index" :action />
        <SmartMenu v-if="dropdownActions.length > 0">
            <slot />
            <SmartMenuContent align="end">
                <ActionMenuDropdownItem v-for="(action, index) in dropdownActions" :key="index" :action />
            </SmartMenuContent>
        </SmartMenu>
    </div>
</template>
