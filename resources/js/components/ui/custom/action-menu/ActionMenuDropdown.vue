<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ActionItem } from '@/components/ui/custom/action-menu/interface';
import { SmartMenu, SmartMenuContent, SmartMenuTrigger } from '@/components/ui/custom/smart-menu';
import { EllipsisVerticalIcon } from 'lucide-vue-next';
import { computed } from 'vue';
import { provideActionMenuContext } from './ActionMenu.vue';
import ActionMenuDropdownItem from './ActionMenuDropdownItem.vue';

type Props = {
    actions: ActionItem[];
};
const props = defineProps<Props>();

provideActionMenuContext({
    actions: computed(() => props.actions),
});
</script>

<template>
    <SmartMenu>
        <SmartMenuTrigger role="actions" as-child>
            <slot>
                <Button variant="ghost" size="icon">
                    <EllipsisVerticalIcon />
                </Button>
            </slot>
        </SmartMenuTrigger>
        <SmartMenuContent align="end">
            <ActionMenuDropdownItem v-for="(action, index) in actions" :key="index" :action />
        </SmartMenuContent>
    </SmartMenu>
</template>
