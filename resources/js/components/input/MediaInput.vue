<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { useAxios } from '@/composables';
import { objectToFormData } from '@/lib/inertia';
import { cn } from '@/lib/utils';
import { MediaResource } from '@/types';
import { AxiosError } from 'axios';
import { PencilIcon } from 'lucide-vue-next';
import { computed, HTMLAttributes, ref } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    modelType: string;
    modelId: number;
    collection: string;
    type?: 'document' | 'image' | 'video' | 'other';
    accept?: HTMLInputElement['accept'];
    class?: HTMLAttributes['class'];
};
const { modelType, modelId, collection, type = 'other', ...props } = defineProps<Props>();

const model = defineModel<MediaResource>();
const error = defineModel<string>('error');

const axios = useAxios();
const progress = ref<number>(0);

const accept = computed(() => {
    if (props.accept) {
        return props.accept;
    }

    switch (type) {
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

    axios
        .post<MediaResource>(
            route('media.store', { modelType, modelId, collection }),
            objectToFormData({
                file,
            }),
            {
                onUploadProgress: (event) => {
                    progress.value = event.percentage ?? 0;
                },
            },
        )
        .then((response) => {
            model.value = response.data;
        })
        .catch(({ response }: AxiosError<{ message: string }>) => {
            error.value = response?.data.message;
        });
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger :class="cn('relative w-min p-3', props.class)">
            <slot />
            <Button class="absolute right-0 bottom-0 size-8" v-bind="$attrs" variant="outline" size="icon">
                <PencilIcon />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem as-child>
                <label>
                    {{ $t('components.input.media.upload') }}
                    <input class="sr-only" type="file" :accept @change="submit($event)" />
                </label>
            </DropdownMenuItem>
            <DropdownMenuItem @click="model = undefined">
                {{ $t('components.input.media.delete') }}
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
