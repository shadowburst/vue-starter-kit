<script setup lang="ts">
import { Button, ButtonProps } from '@/components/ui/button';
import { LoadableIcon } from '@/components/ui/custom/loadable';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { reactiveOmit } from '@vueuse/core';
import { SaveIcon } from 'lucide-vue-next';
import { useForwardProps } from 'reka-ui';
import { computed } from 'vue';
import { injectFormContext } from './Form.vue';

const props = withDefaults(defineProps<ButtonProps>(), {
    type: 'submit',
});
const delegatedProps = reactiveOmit(props, 'disabled');
const forwarded = useForwardProps(delegatedProps);

const form = injectFormContext();

const loading = computed(() => form.processing);

const disabled = computed(() => props.disabled || loading.value);
</script>

<template>
    <Button v-bind="forwarded" :disabled>
        <slot :loading>
            <LoadableIcon :icon="SaveIcon" :loading="loading" />
            <CapitalizeText>
                {{ $t('save') }}
            </CapitalizeText>
        </slot>
    </Button>
</template>
