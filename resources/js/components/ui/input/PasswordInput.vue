<template>
    <div class="relative w-full">
        <BaseInput class="pr-10" v-bind="forwarded" :type />
        <Button class="absolute inset-y-0 end-0" variant="ghost" size="icon" @click="toggle()">
            <component class="size-6" :is="hidden ? EyeOffIcon : EyeIcon" />
        </Button>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { EyeIcon, EyeOffIcon } from 'lucide-vue-next';
import { useForwardPropsEmits } from 'reka-ui';
import { computed, ref } from 'vue';
import BaseInput from './BaseInput.vue';
import { InputEmits, InputProps } from './interface';

const props = defineProps<InputProps>();

const emits = defineEmits<InputEmits>();

const forwarded = useForwardPropsEmits(props, emits);

const type = ref<InputProps['type']>('password');
const hidden = computed((): boolean => type.value === 'password');
function toggle() {
    type.value = hidden.value ? 'text' : 'password';
}
</script>
