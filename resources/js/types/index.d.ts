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
export type PaginatedCollection<T> = {
    data: Array<T>;
    links: Array<PaginatedCollectionLink>;
    meta: PaginatedCollectionMeta;
};

export * from './backend';
export * from './i18n';
export * from './inertia';
export * from './ui';
export * from './utility';
