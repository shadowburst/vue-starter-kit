import { PrimitiveProps } from 'reka-ui';
import { HTMLAttributes } from 'vue';
import { ButtonVariants } from '.';

export type ButtonProps = PrimitiveProps & {
    type?: HTMLButtonElement['type'];
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    class?: HTMLAttributes['class'];
};
