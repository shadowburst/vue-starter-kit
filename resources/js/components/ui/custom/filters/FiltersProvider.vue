<script setup lang="ts" generic="TForm extends FormDataType<TForm>">
import { Form } from '@/components/ui/custom/form';
import { Drawer } from '@/components/ui/drawer';
import { useTailwindBreakpoints } from '@/composables';
import { FormDataType } from '@inertiajs/core';
import { InertiaForm } from '@inertiajs/vue3';

type Props = {
    filters: InertiaForm<TForm>;
};
const props = defineProps<Props>();

type Emits = {
    submit: [];
};
defineEmits<Emits>();

const { sm: isDekstop } = useTailwindBreakpoints();
</script>

<template>
    <Form :form="filters" @submit="$emit('submit')">
        <Drawer :direction="isDekstop ? 'right' : 'bottom'">
            <slot />
        </Drawer>
    </Form>
</template>
