<script setup lang="ts">
import { InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput } from '@/components/ui/input-group';
import { reactiveOmit, useToggle } from '@vueuse/core';
import { EyeIcon, EyeOffIcon } from 'lucide-vue-next';
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

const [type, toggleType] = useToggle('password', {
    truthyValue: 'password',
    falsyValue: 'text',
});

const { forwardRef } = useForwardExpose();
</script>

<template>
    <InputGroup :class="props.class">
        <InputGroupInput v-bind="{ ...$attrs, ...forwarded }" v-model="model" :type :ref="forwardRef" />
        <InputGroupAddon align="inline-end">
            <InputGroupButton size="icon-xs" @click="toggleType()">
                <component :is="type === 'password' ? EyeOffIcon : EyeIcon" />
            </InputGroupButton>
        </InputGroupAddon>
    </InputGroup>
</template>
