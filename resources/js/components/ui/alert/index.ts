import { cva, type VariantProps } from 'class-variance-authority';

export { default as Alert } from './Alert.vue';
export { default as AlertDescription } from './AlertDescription.vue';
export { default as AlertTitle } from './AlertTitle.vue';

export const alertVariants = cva(
    'relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-current',
    {
        variants: {
            variant: {
                default: 'bg-background text-foreground',
                primary: 'bg-background text-primary',
                destructive: 'border-destructive/50 text-destructive dark:border-destructive',
            },
        },
        defaultVariants: {
            variant: 'default',
        },
    },
);

export type AlertVariants = VariantProps<typeof alertVariants>;
