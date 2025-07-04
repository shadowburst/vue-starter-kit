<script setup lang="ts">
import { Button, ButtonProps } from '@/components/ui/button';
import { LoadingIcon } from '@/components/ui/custom/loading';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { SaveIcon } from 'lucide-vue-next';
import { useForwardProps } from 'reka-ui';
import { computed } from 'vue';
import { injectFormContext } from './Form.vue';

type Props = ButtonProps & {
    disabled?: boolean;
};
const props = withDefaults(defineProps<Props>(), {
    type: 'submit',
});
const delegatedProps = reactiveOmit(props, 'disabled', 'class');
const forwarded = useForwardProps(delegatedProps);

const { form, disabled: formDisabled } = injectFormContext();

const loading = computed(() => form.processing);

const disabled = computed(() => formDisabled.value || props.disabled || loading.value);
</script>

<template>
    <Button
        v-if="!formDisabled"
        v-bind="forwarded"
        :class="cn('relative', loading && 'disabled:opacity-100', props.class)"
        :disabled
    >
        <div class="absolute inset-0 grid place-items-center" v-if="loading">
            <LoadingIcon />
        </div>
        <div class="contents" :class="{ invisible: loading }">
            <slot>
                <SaveIcon />
                <CapitalizeText>
                    {{ $t('save') }}
                </CapitalizeText>
            </slot>
        </div>
    </Button>
</template>
