import { LucideIcon } from 'lucide-vue-next';
import { VNode } from 'vue';

type BaseActionItem<T> = {
    disabled?: boolean | ((payload: T) => boolean);
    hidden?: boolean | ((payload: T) => boolean);
};
export type HrefActionItem<T> = BaseActionItem<T> & {
    type: 'href';
    label: string;
    icon: LucideIcon;
    href: string | ((payload: T) => string);
};
export type CallbackActionItem<T> = BaseActionItem<T> & {
    type: 'callback';
    label: string;
    icon: LucideIcon;
    callback: (payload: T) => void;
};
export type CustomActionItem<T> = BaseActionItem<T> & {
    type: 'custom';
    component: (payload: T) => VNode;
};

export type ActionItem<T> = CallbackActionItem<T> | CustomActionItem<T> | HrefActionItem<T>;
