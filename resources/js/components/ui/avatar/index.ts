import { cva, type VariantProps } from 'class-variance-authority';

export { default as Avatar } from './Avatar.vue';
export { default as AvatarFallback } from './AvatarFallback.vue';
export { default as AvatarImage } from './AvatarImage.vue';

export type { AvatarProps } from './interface';

export const avatarVariant = cva(
    'inline-flex items-center justify-center font-normal text-foreground select-none shrink-0 bg-muted overflow-hidden',
    {
        variants: {
            size: {
                sm: 'size-10 text-xs',
                base: 'size-16 text-2xl',
                lg: 'size-32 text-5xl',
            },
            shape: {
                circle: 'rounded-full',
                square: 'rounded-md',
            },
        },
    },
);

export type AvatarVariants = VariantProps<typeof avatarVariant>;
