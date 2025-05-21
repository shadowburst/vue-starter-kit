<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { EyeIcon, EyeOffIcon } from 'lucide-vue-next';
import { useForwardExpose, useForwardPropsEmits } from 'reka-ui';
import { computed, ref } from 'vue';
import { InputEmits, InputProps } from './interface';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps<InputProps>();
const emits = defineEmits<InputEmits>();
const forwarded = useForwardPropsEmits(props, emits);

const type = ref<InputProps['type']>('password');
const hidden = computed((): boolean => type.value === 'password');
function toggle() {
    type.value = hidden.value ? 'text' : 'password';
}

const { forwardRef } = useForwardExpose();
</script>

<template>
    <div class="relative w-full">
        <Input class="pr-10" v-bind="{ ...forwarded, ...$attrs }" :ref="forwardRef" :type />
        <Button class="absolute inset-y-0 end-0" variant="ghost" size="icon" @click="toggle()">
            <component class="size-4" :is="hidden ? EyeOffIcon : EyeIcon" />
        </Button>
    </div>
</template>
