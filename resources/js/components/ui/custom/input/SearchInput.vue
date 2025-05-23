<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { SearchIcon } from 'lucide-vue-next';
import { useForwardExpose, useForwardPropsEmits } from 'reka-ui';
import { ref } from 'vue';
import { InputEmits, InputProps } from './interface';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps<InputProps>();
const emits = defineEmits<InputEmits>();
const forwarded = useForwardPropsEmits(props, emits);

const type = ref<InputProps['type']>('search');
const { forwardRef } = useForwardExpose();
</script>

<template>
    <div class="relative w-full">
        <div class="absolute inset-y-px start-px grid w-9 place-items-center">
            <SearchIcon class="size-4" />
        </div>
        <Input class="pl-10" v-bind="{ ...forwarded, ...$attrs }" :ref="forwardRef" :type />
    </div>
</template>
