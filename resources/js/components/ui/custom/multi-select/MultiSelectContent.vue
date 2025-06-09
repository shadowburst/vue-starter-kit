<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxList } from '@/components/ui/combobox';
import { useArrayWrap } from '@/composables';
import { injectComboboxRootContext } from 'reka-ui';
import { injectMultiSelectRootContext } from './MultiSelect.vue';

const { open, modelValue, allItems } = injectComboboxRootContext();
const { displayValue } = injectMultiSelectRootContext();

const models = useArrayWrap(modelValue);
</script>

<template>
    <ComboboxList>
        <ComboboxInput />
        <ComboboxGroup>
            <ComboboxItem v-for="(item, index) in allItems" :key="index" :value="item"> </ComboboxItem>
        </ComboboxGroup>
        <Button v-if="models.length > 0" variant="ghost">
            {{ $t('components.ui.custom.multi_select.reset') }}
        </Button>
    </ComboboxList>
</template>
