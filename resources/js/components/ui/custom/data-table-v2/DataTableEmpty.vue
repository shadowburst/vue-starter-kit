<script setup lang="ts">
import { Empty, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import { PackageOpenIcon } from 'lucide-vue-next';
</script>

<template>
    <Empty>
        <EmptyMedia variant="icon">
            <PackageOpenIcon />
        </EmptyMedia>
        <EmptyHeader>
            <EmptyTitle>
                {{ $t('components.ui.custom.data_table.empty.title') }}
            </EmptyTitle>
        </EmptyHeader>
    </Empty>
</template>
