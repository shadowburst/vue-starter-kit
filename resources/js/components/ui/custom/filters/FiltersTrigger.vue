<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { injectFormContext } from '@/components/ui/custom/form';
import { CapitalizeText } from '@/components/ui/custom/typography';
import { DrawerTrigger } from '@/components/ui/drawer';
import { FilterIcon, XIcon } from 'lucide-vue-next';

const { form } = injectFormContext();
</script>

<template>
    <ButtonGroup>
        <DrawerTrigger as-child>
            <Button variant="outline">
                <FilterIcon />
                <CapitalizeText>
                    {{ $t('components.ui.custom.filters.trigger.label') }}
                </CapitalizeText>
            </Button>
        </DrawerTrigger>
        <Button v-if="form.isDirty" variant="outline" size="icon" @click="form.reset()">
            <XIcon />
        </Button>
    </ButtonGroup>
</template>
