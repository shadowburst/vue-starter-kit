<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { RoleResource } from '@/types';
import { computed } from 'vue';

type Props = {
    role: RoleResource;
};
const props = defineProps<Props>();

const variant = computed(() => {
    switch (props.role.name.toLowerCase()) {
        case 'admin':
            return 'destructive';
        case 'member':
            return 'outline';
        default:
            return undefined;
    }
});
</script>

<template>
    <Badge :variant>
        <CapitalizeText>
            {{ role.name }}
        </CapitalizeText>
    </Badge>
</template>
