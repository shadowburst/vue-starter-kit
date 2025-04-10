import type { ErrorBag, Errors } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import { AuthUserResource, ToastMessagesData } from './backend';

export type SharedData = {
    name: string;
    auth: {
        user: AuthUserResource;
    };
    toast: ToastMessagesData;
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export * from './backend';
export * from './ui';
