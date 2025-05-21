<script setup lang="ts">
import { TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Columns3Icon, ListIcon } from 'lucide-vue-next';
</script>

<template>
    <TabsList>
        <TabsTrigger value="table">
            <ListIcon />
        </TabsTrigger>
        <TabsTrigger value="card">
            <Columns3Icon />
        </TabsTrigger>
    </TabsList>
</template>
