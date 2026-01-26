<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { computed } from 'vue';
import { ActionItem } from './interface';

type Props = {
    action: ActionItem;
};
const { action } = defineProps<Props>();

const variant = computed((): ActionItem['variant'] => action.variant ?? 'outline');
const size = computed((): ActionItem['size'] => action.size ?? 'icon-sm');
const label = computed((): string => (!size.value?.startsWith('icon') ? action.label : ''));
</script>

<template>
    <Button v-if="action.type === 'href'" as-child :variant :size>
        <InertiaLink :href="action.href" :disabled="action.disabled">
            <component :is="action.icon" />
            <CapitalizeText v-if="label">
                {{ label }}
            </CapitalizeText>
        </InertiaLink>
    </Button>
    <Button v-else :variant :size :disabled="action.disabled" @click="action.callback()">
        <component :is="action.icon" />
        <CapitalizeText v-if="label">
            {{ label }}
        </CapitalizeText>
    </Button>
</template>
