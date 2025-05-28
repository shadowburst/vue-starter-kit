<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { InertiaLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { cn } from '@/lib/utils';
import { usePage } from '@inertiajs/vue3';
import { ExternalLinkIcon, InfoIcon, XIcon } from 'lucide-vue-next';
import { computed, HTMLAttributes } from 'vue';

type Props = {
    class?: HTMLAttributes['class'];
};
const props = defineProps<Props>();

const banner = computed(() => usePage().props.banner);
</script>

<template>
    <div v-if="banner" :class="cn('bg-warning/20 grid items-stretch rounded-t-xl border-b sm:flex', props.class)">
        <Alert class="grow border-0 bg-transparent">
            <InfoIcon />
            <AlertTitle>
                {{ banner.name }}
            </AlertTitle>
            <AlertDescription>
                {{ banner.message }}
            </AlertDescription>
        </Alert>
        <div class="flex items-center justify-between gap-2 pr-4 max-sm:px-4 max-sm:pb-3">
            <Button v-if="banner.action" variant="outline" as-child>
                <a :href="banner.action" target="_blank">
                    <ExternalLinkIcon />
                    <CapitalizeText>
                        {{ $t('more_details') }}
                    </CapitalizeText>
                </a>
            </Button>
            <Button size="icon" variant="ghost">
                <InertiaLink method="patch" :href="route('banners.dismiss', { banner })">
                    <XIcon />
                </InertiaLink>
            </Button>
        </div>
    </div>
</template>
