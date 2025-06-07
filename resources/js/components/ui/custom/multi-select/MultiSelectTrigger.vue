<script setup lang="ts">
import { Button, ButtonProps } from '@/components/ui/button';
import { ComboboxAnchor, ComboboxTrigger } from '@/components/ui/combobox';
import { Separator } from '@/components/ui/separator';
import { useArrayWrap } from '@/composables';
import { cn } from '@/lib/utils';
import { reactiveOmit } from '@vueuse/core';
import { CirclePlusIcon } from 'lucide-vue-next';
import { injectComboboxRootContext, useForwardProps } from 'reka-ui';
import { Badge } from '../../badge';
import { injectMultiSelectRootContext } from './MultiSelect.vue';

const props = withDefaults(defineProps<ButtonProps>(), {
    variant: 'outline',
});
const delegatedProps = reactiveOmit(props, 'class');
const forwarded = useForwardProps(delegatedProps);

const { modelValue } = injectComboboxRootContext();
const models = useArrayWrap(modelValue);

const { displayValue } = injectMultiSelectRootContext();
</script>

<template>
    <ComboboxAnchor as-child>
        <ComboboxTrigger as-child>
            <Button v-bind="forwarded" :class="cn('border-dashed', props.class)">
                <CirclePlusIcon />
                <slot />
                <template v-if="models.length > 0">
                    <Separator orientation="vertical" />
                    <Badge v-if="models.length > 2" variant="secondary">
                        {{ $transChoice('components.ui.custom.multi_select.selected', models.length) }}
                    </Badge>
                    <template v-else>
                        <Badge v-for="(item, index) in models" :key="index" variant="secondary">
                            {{ displayValue(item) }}
                        </Badge>
                    </template>
                </template>
            </Button>
        </ComboboxTrigger>
    </ComboboxAnchor>
</template>
