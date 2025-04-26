<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button';
import { useIsDesktop } from '@/composables';
import { DataTableAction } from './interface';

type Props = {
    item: TData;
    actions: DataTableAction<TData>[];
};
defineProps<Props>();

const isDesktop = useIsDesktop();
</script>

<template>
    <div class="flex items-center gap-2" v-if="isDesktop">
        <template v-for="action in actions" :key="action.label">
            <Button>
                {{ action.label }}
            </Button>
        </template>
    </div>
</template>
