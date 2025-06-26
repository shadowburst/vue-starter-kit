<script setup lang="ts">
import AppLogoIcon from '@/components/icon/AppLogoIcon.vue';
import { Avatar, AvatarFallback, AvatarProps } from '@/components/ui/avatar';
import { cn } from '@/lib/utils';
import type { MediaResource } from '@/types';
import { reactiveOmit } from '@vueuse/core';
import { useAxios } from '@vueuse/integrations/useAxios.mjs';
import { useForwardProps } from 'reka-ui';
import { ref, watch } from 'vue';

type Props = AvatarProps & {
    media?: MediaResource;
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
            execute(props.media.url).then(({ data }) => {
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
        <AvatarFallback class="rounded-lg" v-if="!svgSrc">
            <AppLogoIcon />
        </AvatarFallback>
        <AvatarFallback class="rounded-lg *:size-full *:fill-current" v-else as-child>
            <span v-html="svgSrc"> </span>
        </AvatarFallback>
    </Avatar>
</template>
