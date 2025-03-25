import type { ErrorBag, Errors } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import { AuthUserResource } from './backend.d.ts';

export type SharedData = {
    name: string;
    auth: {
        user: AuthUserResource;
    };
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
};

export * from './backend.d.ts';
export * from './ui.d.ts';
export * from './utility.d.ts';
