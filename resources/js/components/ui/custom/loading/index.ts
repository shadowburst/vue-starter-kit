export { default as LoadingIcon } from './LoadingIcon.vue';

import { cva, type VariantProps } from 'class-variance-authority';

export const loadingIconVariants = cva('animate-pulse ', {
    variants: {
        variant: {
            default: 'text-current',
            primary: 'text-primary',
        },
        size: {
            md: 'size-6',
            lg: 'size-8',
            sm: 'size-4',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'md',
    },
});

export type LoadingIconVariants = VariantProps<typeof loadingIconVariants>;
