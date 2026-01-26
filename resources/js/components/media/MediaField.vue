<script lang="ts">
export type MediaFieldProps = FormFieldProps & {
    collection: MediaCollectionData;
    modelType: string;
    customProperties?: Record<string, any>;
};
</script>

<script setup lang="ts">
import { FormField, formFieldPropKeys, FormFieldProps } from '@/components/ui/custom/form';
import { objectToFormData } from '@/lib/inertia';
import { MediaCollectionData, MediaData } from '@/types';
import MediaController from '@/wayfinder/App/Http/Controllers/MediaController';
import { reactivePick, useDropZone, useFileDialog } from '@vueuse/core';
import { useAxios } from '@vueuse/integrations/useAxios';
import axios, { AxiosError } from 'axios';
import { useForwardProps } from 'reka-ui';
import { computed, ref, useTemplateRef } from 'vue';

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(defineProps<MediaFieldProps>(), {
    customProperties: () => ({}),
});

const forwardedFieldProps = useForwardProps(reactivePick(props, ...formFieldPropKeys));

const model = defineModel<MediaData>();

const error = ref<string>();
const errors = computed(() => {
    if (error.value) {
        return [error.value];
    }

    return props.errors;
});

const dataTypes = computed(() => props.collection.mime_types);
const accept = computed(() => dataTypes.value.join(','));

const progress = ref(0);
const storeMedia = useAxios<MediaData>(
    '',
    { method: 'POST' },
    axios.create({
        onUploadProgress: (progressEvent) => {
            progress.value = (progressEvent.progress ?? 0) * 100;
        },
    }),
    { immediate: false },
);

function submit(file: File) {
    const { modelType, collection, customProperties } = props;

    progress.value = 0;
    storeMedia
        .execute(MediaController.store({ modelType, collection: collection.name }).url, {
            data: objectToFormData({
                file,
                custom_properties: customProperties,
            }),
        })
        .then((response) => {
            model.value = response.data.value;
            error.value = undefined;
        })
        .catch(({ response }: AxiosError<{ message: string }>) => {
            error.value = response?.data.message;
        });
}

const dropZoneRef = useTemplateRef('dropZone');
const { isOverDropZone } = useDropZone(dropZoneRef, {
    dataTypes,
    onDrop: (files) => {
        if (!files?.length) {
            return;
        }
        submit(files[0]);
    },
});

const { open: openFileDialog, onChange } = useFileDialog({
    accept,
    reset: true,
});
onChange((files) => {
    if (!files?.length) {
        return;
    }
    submit(files[0]);
});
</script>

<template>
    <FormField v-bind="forwardedFieldProps" :errors>
        <div ref="dropZone" class="contents">
            <slot :is-over-drop-zone :open-file-dialog :progress />
        </div>
    </FormField>
</template>
