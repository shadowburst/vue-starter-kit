<script setup lang="ts">
import { TeamListResource } from '@/types';
import TeamLogoIcon from './TeamLogoIcon.vue';

type Props = {
    team: TeamListResource;
};
defineProps<Props>();
</script>

<template>
    <div class="bg-primary text-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md">
        <TeamLogoIcon class="size-full bg-inherit text-inherit" :media="team.logo" />
    </div>
    <div class="ml-1 grid flex-1 gap-0.5 text-left text-sm">
        <span class="truncate leading-tight font-semibold capitalize">
            {{ team.name }}
        </span>
    </div>
</template>
