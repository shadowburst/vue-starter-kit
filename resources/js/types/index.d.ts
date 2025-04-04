import type { ErrorBag, Errors } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import { AuthUserResource, ToastMessagesData } from './backend.d.ts';

export type SharedData = {
    name: string;
    auth: {
        user: AuthUserResource;
    };
    toast: ToastMessagesData;
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
};

export * from './backend.d.ts';
export * from './ui.d.ts';
