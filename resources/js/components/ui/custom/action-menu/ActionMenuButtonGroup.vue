<script setup lang="ts">
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';
import { injectActionMenuContext } from './ActionMenu.vue';
import ActionMenuButton from './ActionMenuButton.vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { actions } = injectActionMenuContext();
</script>

<template>
    <div :class="cn('flex items-center gap-2', props.class)">
        <ActionMenuButton v-for="(action, index) in actions" :key="index" :action />
    </div>
</template>
