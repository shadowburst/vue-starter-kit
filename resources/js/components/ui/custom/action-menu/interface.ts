import { ButtonVariants } from '@/components/ui/button';
import { LucideIcon } from 'lucide-vue-next';

type BaseActionItem = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean;
    hidden?: boolean;
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
};
export type HrefActionItem = BaseActionItem & {
    href: string;
    callback?: never;
};
export type CallbackActionItem = BaseActionItem & {
    callback: () => void;
    href?: never;
};

export type ActionItem = CallbackActionItem | HrefActionItem;
