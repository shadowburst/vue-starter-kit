<script setup lang="ts" generic="T">
import { CapitalizeText } from '@/components/ui/custom/typography';
import { HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
</script>

<template>
    <CapitalizeText role="actions" :class="props.class">
        <slot>
            {{ $t('actions') }}
        </slot>
    </CapitalizeText>
</template>
