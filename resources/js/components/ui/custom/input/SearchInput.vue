<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { SearchIcon, XIcon } from 'lucide-vue-next';
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
        <Input class="px-10" v-bind="{ ...forwarded, ...$attrs }" :ref="forwardRef" :type />
        <div class="absolute inset-y-px end-px grid place-items-center" v-if="modelValue">
            <Button class="h-full rounded-l-none" size="icon" variant="ghost" @click="$emit('update:modelValue', '')">
                <XIcon />
            </Button>
        </div>
    </div>
</template>

<style scoped>
input[type='search']::-webkit-search-decoration,
input[type='search']::-webkit-search-cancel-button,
input[type='search']::-webkit-search-results-button,
input[type='search']::-webkit-search-results-decoration {
    -webkit-appearance: none;
}
</style>
