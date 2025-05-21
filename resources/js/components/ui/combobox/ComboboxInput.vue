<script setup lang="ts">
import { cn } from '@/lib/utils';
import { SearchIcon } from 'lucide-vue-next';
import { ComboboxInput, type ComboboxInputEmits, type ComboboxInputProps, useForwardPropsEmits } from 'reka-ui';
import { computed, type HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps<
    ComboboxInputProps & {
        class?: HTMLAttributes['class'];
    }
>();

const emits = defineEmits<ComboboxInputEmits>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <div class="flex h-9 items-center gap-2 border-b px-3" data-slot="command-input-wrapper">
        <SearchIcon class="size-4 shrink-0 opacity-50" />
        <ComboboxInput
            v-bind="{ ...forwarded, ...$attrs }"
            data-slot="command-input"
            :class="
                cn(
                    'placeholder:text-muted-foreground flex h-10 w-full rounded-md bg-transparent py-3 text-sm outline-hidden disabled:cursor-not-allowed disabled:opacity-50',
                    props.class,
                )
            "
        >
            <slot />
        </ComboboxInput>
    </div>
</template>
