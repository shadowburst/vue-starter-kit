<script setup lang="ts">
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { cn } from '@/lib/utils';
import { show } from '@/routes/media';
import type { MediaData } from '@/types';
import { reactiveOmit } from '@vueuse/core';
import { useAxios } from '@vueuse/integrations/useAxios';
import { useForwardProps } from 'reka-ui';
import { HTMLAttributes, ref, watch } from 'vue';

type Props = {
    media: MediaData | null | undefined;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'media', 'class');
const forwarded = useForwardProps(delegatedProps);

const { execute } = useAxios<string>();

const svgSrc = ref<string>();
watch(
    () => props.media,
    () => {
        if (props.media) {
            execute(show({ media: props.media }).url).then(({ data }) => {
                svgSrc.value = data.value;
            });
        } else {
            svgSrc.value = undefined;
        }
    },
    { immediate: true },
);
</script>

<template>
    <Avatar v-bind="forwarded" :class="cn('p-1', props.class)">
        <AvatarFallback class="rounded-lg bg-transparent" v-if="!svgSrc">
            <AppLogoIcon />
        </AvatarFallback>
        <AvatarFallback class="rounded-lg *:size-full *:fill-current" v-else as-child>
            <span v-html="svgSrc"> </span>
        </AvatarFallback>
    </Avatar>
</template>
