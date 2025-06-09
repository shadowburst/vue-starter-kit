import { InertiaLinkProps } from '@inertiajs/vue3';
import { LucideIcon } from 'lucide-vue-next';

export type BreadcrumbItem = {
    title: string;
    href: string;
};

export type NavItem = {
    title: string;
    href: string;
    icon?: LucideIcon;
    hidden?: bool;
    isActive?: boolean;
    options?: Partial<InertiaLinkProps>;
};
