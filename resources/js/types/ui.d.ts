import { InertiaLinkProps } from '@inertiajs/vue3';
import { LucideIcon } from 'lucide-vue-next';

export type BreadcrumbItemType = {
    title: string;
    href: string;
};

type NavItemBase = {
    title: string;
    icon?: LucideIcon;
    hidden?: bool;
};
export type NavItemGroup = NavItemBase & {
    href?: never;
    items: NavItemHref[];
};
export type NavItemHref = NavItemBase & {
    items?: never;
    href: string;
    isActive?: boolean;
    options?: Partial<InertiaLinkProps>;
};
export type NavItem = NavItemGroup | NavItemHref;
