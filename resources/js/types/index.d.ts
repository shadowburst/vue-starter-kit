import type { ErrorBag, Errors } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';
import { AuthUserResource } from './backend.d.ts';

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type SharedData = {
    name: string;
    auth: {
        user: AuthUserResource;
    };
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
};

export type BreadcrumbItemType = BreadcrumbItem;

export * from './backend.d.ts';
export * from './utility.d.ts';
