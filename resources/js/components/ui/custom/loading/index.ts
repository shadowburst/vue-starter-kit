export { default as LoadingIcon } from './LoadingIcon.vue';

import { cva, type VariantProps } from 'class-variance-authority';

export const loadingIconVariants = cva('animate-pulse ', {
    variants: {
        variant: {
            default: 'text-current',
            primary: 'text-primary',
        },
        size: {
            md: 'size-5',
            lg: 'size-6',
            sm: 'size-4',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'md',
    },
});

export type LoadingIconVariants = VariantProps<typeof loadingIconVariants>;
