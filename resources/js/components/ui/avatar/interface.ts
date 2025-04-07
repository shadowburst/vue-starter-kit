import { HTMLAttributes } from 'vue';
import { AvatarVariants } from '.';

export type AvatarProps = {
    class?: HTMLAttributes['class'];
    size?: AvatarVariants['size'];
    shape?: AvatarVariants['shape'];
};
