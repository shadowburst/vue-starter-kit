import type { ErrorBag, Errors } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import { AuthAbilitiesResource, BannerResource, TeamResource, ToastMessagesData, UserResource } from './backend';
export { FormDataType } from '@inertiajs/core';

export type Enum<T extends string> = {
    value: T;
    label: string;
};

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    auth: {
        abilities: AuthAbilitiesResource;
        team?: TeamResource;
        user?: UserResource;
    };
    toast: ToastMessagesData;
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    locale: string;
    default: {
        per_page: number;
    };
    banner?: BannerResource;
};
