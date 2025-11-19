<script setup lang="ts">
import { Button, ButtonVariants } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Spinner } from '@/components/ui/spinner';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { CheckIcon, SaveIcon } from 'lucide-vue-next';
import { PrimitiveProps, useForwardProps } from 'reka-ui';
import { computed, FunctionalComponent, HTMLAttributes } from 'vue';
import { injectFormContext } from './Form.vue';

type Props = PrimitiveProps & {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    icon?: FunctionalComponent | false;
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
const props = withDefaults(defineProps<Props>(), {
    icon: undefined,
});
const delegatedProps = reactiveOmit(props, 'disabled', 'class');
const forwarded = useForwardProps(delegatedProps);

const formContext = injectFormContext();

const loading = computed(() => formContext.form.value.processing);

const disabled = computed(
    () =>
        props.disabled ||
        loading.value ||
        !formContext.canSubmit.value ||
        formContext.disabled.value ||
        formContext.form.value.recentlySuccessful,
);

const icon = computed(() => {
    if (props.icon === false) {
        return;
    }
    if (loading.value) {
        return Spinner;
    }
    if (formContext.form.value.recentlySuccessful) {
        return CheckIcon;
    }
    return props.icon ?? SaveIcon;
});
</script>

<template>
    <Button
        v-if="!formContext.disabled.value"
        v-bind="forwarded"
        type="submit"
        :disabled
        :class="cn({ 'disabled:opacity-100': loading || formContext.form.value.recentlySuccessful }, props.class)"
    >
        <component v-if="icon" :is="icon" />
        <CapitalizeText>
            <slot>
                {{ $t('save') }}
            </slot>
        </CapitalizeText>
    </Button>
</template>
