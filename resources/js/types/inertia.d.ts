import type { ErrorBag, Errors } from '@inertiajs/core';
import { FormDataConvertible } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import { BannerResource, TeamResource, ToastMessagesData, UserAbilitiesResource, UserResource } from './backend';

export type Enum<T extends string> = {
    value: T;
    label: string;
};

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    auth?: {
        user: UserResource;
        abilities: UserAbilitiesResource;
        team: TeamResource;
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

export type FormDataType = Record<string, FormDataConvertible>;
