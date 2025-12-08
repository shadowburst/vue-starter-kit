<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { SmartMenu, SmartMenuContent, SmartMenuTrigger } from '@/components/ui/custom/smart-menu';
import { EllipsisVerticalIcon } from 'lucide-vue-next';
import { injectActionMenuContext } from './ActionMenu.vue';
import ActionMenuDropdownItem from './ActionMenuDropdownItem.vue';

const { actions } = injectActionMenuContext();
</script>

<template>
    <SmartMenu>
        <SmartMenuTrigger as-child>
            <Button role="actions" variant="ghost" size="icon">
                <EllipsisVerticalIcon />
            </Button>
        </SmartMenuTrigger>
        <SmartMenuContent align="end">
            <ActionMenuDropdownItem v-for="(action, index) in actions" :key="index" :action />
        </SmartMenuContent>
    </SmartMenu>
</template>
