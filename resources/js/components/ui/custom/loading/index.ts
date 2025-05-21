import { cva, type VariantProps } from 'class-variance-authority';

export { default as LoadingContent } from './LoadingContent.vue';
export { default as LoadingIcon } from './LoadingIcon.vue';

export const loadingVariants = cva('', {
    variants: {
        variant: {
            default: 'text-current',
            primary: 'text-primary',
        },
        size: {
            default: 'size-5',
            sm: 'size-4',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'default',
    },
});

export type LoadingVariants = VariantProps<typeof loadingVariants>;
