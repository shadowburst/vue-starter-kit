import { ButtonVariants } from '@/components/ui/button';
import { LucideIcon } from 'lucide-vue-next';

type BaseActionItem = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean;
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
};
export type HrefActionItem = BaseActionItem & {
    type: 'href';
    href: string;
};
export type CallbackActionItem = BaseActionItem & {
    type: 'callback';
    callback: () => void;
};

export type ActionItem = CallbackActionItem | HrefActionItem;
