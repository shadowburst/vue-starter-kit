<script setup lang="ts">
import { ActionItem } from '@/components/ui/custom/action-menu/interface';
import { cn } from '@/lib/utils';
import { computed, HTMLAttributes } from 'vue';
import { provideActionMenuContext } from './ActionMenu.vue';
import ActionMenuButton from './ActionMenuButton.vue';

type Props = {
    actions: ActionItem[];
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

provideActionMenuContext({
    actions: computed(() => props.actions),
});
</script>

<template>
    <div :class="cn('flex items-center gap-2', props.class)">
        <ActionMenuButton v-for="(action, index) in actions" :key="index" :action />
    </div>
</template>
