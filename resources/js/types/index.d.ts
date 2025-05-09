import type { ErrorBag, Errors } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import { AuthUserResource, ToastMessagesData } from './backend';

export type SharedData = {
    name: string;
    auth?: {
        user: AuthUserResource;
    };
    toast: ToastMessagesData;
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export type PaginatedCollectionLink = {
    url: string;
    label: string;
    active: boolean;
};
export type PaginatedCollectionMeta = {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
};
export type PaginatedCollection<T extends object> = {
    data: Array<T>;
    links: Array<PaginatedCollectionLink>;
    meta: PaginatedCollectionMeta;
};

export * from './backend';
export * from './i18n';
export * from './ui';
