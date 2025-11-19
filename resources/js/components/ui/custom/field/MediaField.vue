<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { objectToFormData } from '@/lib/inertia';
import { MediaResource } from '@/types';
import { useAxios } from '@vueuse/integrations/useAxios';
import { AxiosError } from 'axios';
import { UploadIcon, XIcon } from 'lucide-vue-next';
import { computed, ref } from 'vue';

import {
    FormControl,
    FormDescription,
    FormError,
    FormField,
    formFieldPropKeys,
    FormFieldProps,
    FormLabel,
} from '@/components/ui/custom/form';
import { useArrayWrap } from '@/composables';
import { reactiveOmit, reactivePick } from '@vueuse/core';
import { useForwardProps } from 'reka-ui';

defineOptions({
    inheritAttrs: false,
});

type Props = FormFieldProps & {
    modelType: string;
    modelId: number;
    collection: string;
    type?: 'document' | 'image' | 'video' | 'other';
    accept?: HTMLInputElement['accept'];
};
const props = withDefaults(defineProps<Props>(), {
    type: 'other',
});
const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));
const forwardedOtherProps = useForwardProps(reactiveOmit(props, ...formFieldPropKeys));

const model = defineModel<MediaResource | null>();

const error = ref<string>();
const errors = computed((): string[] => {
    if (error.value) {
        return [error.value];
    }

    return useArrayWrap(props.errors).value;
});

const { execute: storeMedia } = useAxios<MediaResource>();

const accept = computed(() => {
    if (props.accept) {
        return props.accept;
    }

    switch (props.type) {
        case 'document':
            return 'text/*,application/pdf';
        case 'image':
            return 'image/jpeg,image/png';
        case 'video':
            return 'video/mp4,video/webm';
        default:
            return '';
    }
});

async function submit(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (!file) {
        return;
    }

    const { modelType, modelId, collection } = props;

    storeMedia(route('media.store', { modelType, modelId, collection }), {
        method: 'POST',
        data: objectToFormData({ file }),
    })
        .then((response) => {
            model.value = response.data.value;
        })
        .catch(({ response }: AxiosError<{ message: string }>) => {
            error.value = response?.data.message;
        });
}
</script>

<template>
    <FormField v-bind="forwardedFieldProps" :errors>
        <slot name="label">
            <FormLabel />
        </slot>
        <slot name="input">
            <FormControl>
                <div class="relative w-min!">
                    <slot name="preview" />
                    <Button
                        v-if="!disabled"
                        as="label"
                        variant="outline"
                        size="icon-sm"
                        class="absolute right-0 bottom-0"
                    >
                        <UploadIcon />
                        <input
                            v-bind="{ ...$attrs, ...forwardedOtherProps }"
                            class="sr-only"
                            type="file"
                            :accept
                            @change="submit($event)"
                        />
                    </Button>
                    <Button
                        v-if="!disabled && model"
                        variant="outline"
                        size="icon-sm"
                        class="absolute top-0 right-0"
                        @click="model = undefined"
                    >
                        <XIcon />
                    </Button>
                </div>
            </FormControl>
        </slot>
        <slot name="description">
            <FormDescription />
        </slot>
        <slot name="error">
            <FormError />
        </slot>
    </FormField>
</template>
