<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';
import { TextLink } from '@/components/ui/custom/link';
import { CapitalizeText } from '@/components/ui/custom/typography';
import type { BreadcrumbItemType } from '@/types';

type Props = {
    breadcrumbs: BreadcrumbItemType[];
};
defineProps<Props>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <CapitalizeText v-if="index === breadcrumbs.length - 1" as-child>
                        <BreadcrumbPage>
                            {{ item.title }}
                        </BreadcrumbPage>
                    </CapitalizeText>
                    <BreadcrumbLink v-else as-child>
                        <CapitalizeText as-child>
                            <TextLink :href="item.href ?? '#'">
                                {{ item.title }}
                            </TextLink>
                        </CapitalizeText>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
