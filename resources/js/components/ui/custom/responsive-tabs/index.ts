export { TabsContent as ResponsiveTabContent } from '@/components/ui/tabs';
export { default as ResponsiveTabs } from './ResponsiveTabs.vue';
export { default as ResponsiveTabsTrigger } from './ResponsiveTabsTrigger.vue';

import { cva, type VariantProps } from 'class-variance-authority';

export const responsiveTabsVariants = cva('', {
    variants: {
        variant: {
            default: '',
            ghost: `data-[state=active]:bg-muted data-[state=active]:shadow-none`,
        },
    },
    defaultVariants: {
        variant: 'default',
    },
});

export type ResponsiveTabsVariants = VariantProps<typeof responsiveTabsVariants>;
