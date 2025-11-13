<script setup lang="ts">
import { InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput } from '@/components/ui/input-group';
import { reactiveOmit } from '@vueuse/core';
import { SearchIcon, XIcon } from 'lucide-vue-next';
import { useForwardExpose, useForwardProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();
const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardProps(delegatedProps);

const model = defineModel<string>();

const { forwardRef } = useForwardExpose();
</script>

<template>
    <InputGroup :class="props.class">
        <InputGroupInput v-bind="{ ...$attrs, ...forwarded }" v-model="model" type="search" :ref="forwardRef" />
        <InputGroupAddon>
            <SearchIcon />
        </InputGroupAddon>
        <InputGroupAddon v-if="model && !disabled" align="inline-end">
            <InputGroupButton size="icon-xs" @click="model = ''">
                <XIcon />
            </InputGroupButton>
        </InputGroupAddon>
    </InputGroup>
</template>

<style scoped>
input[type='search']::-webkit-search-decoration,
input[type='search']::-webkit-search-cancel-button,
input[type='search']::-webkit-search-results-button,
input[type='search']::-webkit-search-results-decoration {
    -webkit-appearance: none;
}
</style>
