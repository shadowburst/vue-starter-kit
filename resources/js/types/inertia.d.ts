import type { ErrorBag, Errors } from '@inertiajs/core';
import { FormDataConvertible } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import {
    BannerAppResource,
    ToastMessagesData,
    TrashedFilter,
    UserAbilitiesResource,
    UserAuthResource,
} from './backend';

export type Enum<T extends string> = {
    value: T;
    label: string;
};

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    auth?: {
        user: UserAuthResource;
        abilities: UserAbilitiesResource;
    };
    toast: ToastMessagesData;
    errors: Errors & ErrorBag;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    locale: string;
    default: {
        per_page: number;
    };
    banner?: BannerAppResource;
    enums: {
        trashed_status?: Enum<TrashedFilter>[];
    };
};

export type FormDataType = Record<string, FormDataConvertible>;
