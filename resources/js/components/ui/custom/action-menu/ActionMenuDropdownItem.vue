<script setup lang="ts" generic="T">
import { InertiaLink } from '@/components/ui/custom/link';
import { SmartMenuItem } from '@/components/ui/custom/smart-menu';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { computed } from 'vue';
import { injectActionMenuContext } from './ActionMenu.vue';
import { ActionItem } from './interface';

type Props = {
    action: ActionItem<T>;
};
const { action } = defineProps<Props>();

const { payload } = injectActionMenuContext<T>();

const disabled = computed((): boolean => {
    if (!action.disabled) {
        return false;
    }
    if (typeof action.disabled === 'boolean') {
        return action.disabled;
    }
    return action.disabled(payload.value);
});

const hidden = computed((): boolean => {
    if (!action.hidden) {
        return false;
    }
    if (typeof action.hidden === 'boolean') {
        return action.hidden;
    }
    return action.hidden(payload.value);
});

const href = computed((): string | undefined => {
    if (action.type !== 'href' || !action.href) {
        return;
    }
    if (typeof action.href === 'string') {
        return action.href;
    }
    return action.href(payload.value);
});
</script>

<template>
    <template v-if="!hidden">
        <SmartMenuItem v-if="action.type === 'href'" as-child>
            <InertiaLink :href :disabled>
                <component :is="action.icon" />
                <CapitalizeText>
                    {{ action.label }}
                </CapitalizeText>
            </InertiaLink>
        </SmartMenuItem>
        <SmartMenuItem v-else-if="action.type === 'callback'" :disabled @click="action.callback(payload)">
            <component :is="action.icon" />
            <CapitalizeText>
                {{ action.label }}
            </CapitalizeText>
        </SmartMenuItem>
    </template>
</template>
