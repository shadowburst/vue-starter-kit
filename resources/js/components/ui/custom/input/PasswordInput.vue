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
        <Input class="pe-10" v-bind="{ ...forwarded, ...$attrs }" :ref="forwardRef" :type />
        <div class="absolute inset-y-px end-px grid place-items-center" v-if="!disabled">
            <Button class="h-full rounded-l-none" size="icon" variant="ghost" :tabindex @click="toggle()">
                <component :is="hidden ? EyeOffIcon : EyeIcon" />
            </Button>
        </div>
    </div>
</template>
