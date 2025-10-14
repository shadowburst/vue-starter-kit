<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { Spinner } from '@/components/ui/spinner';
import { cn } from '@/lib/utils';
import { SaveIcon } from 'lucide-vue-next';
import { computed, HTMLAttributes } from 'vue';
import { injectFormContext } from './Form.vue';

type Props = {
    disabled?: boolean;
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const { form, disabled: formDisabled } = injectFormContext();

const loading = computed(() => form.processing);

const disabled = computed(() => formDisabled.value || props.disabled || loading.value);
</script>

<template>
    <Button v-if="!formDisabled" :class="cn('relative', loading && 'disabled:opacity-100', props.class)" :disabled>
        <div class="absolute inset-0 grid place-items-center" v-if="loading">
            <Spinner />
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
