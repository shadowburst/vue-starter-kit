import { LucideIcon } from 'lucide-vue-next';
import { VNode } from 'vue';

type DataTableBaseAction<T> = {
    disabled?: boolean | (T extends any[] ? (items: T) => boolean : (item: T) => boolean);
    hidden?: boolean | (T extends any[] ? (items: T) => boolean : (item: T) => boolean);
};
export type DataTableHrefAction<T> = DataTableBaseAction<T> & {
    type: 'href';
    label: string;
    icon: LucideIcon;
    href: string | ((item: T) => string);
};
export type DataTableCallbackAction<T> = DataTableBaseAction<T> & {
    type: 'callback';
    label: string;
    icon: LucideIcon;
    callback: (item: T) => void;
};
export type DataTableCustomAction<T> = DataTableBaseAction<T> & {
    type: 'custom';
    component: (item: T) => VNode;
};

export type DataTableMultiAction<T> = DataTableBaseAction<T[]> & {
    type: 'multi';
    label: string;
    icon: LucideIcon;
    callback: (items: T[]) => void;
};

export type DataTableRowAction<T> = DataTableCallbackAction<T> | DataTableCustomAction<T> | DataTableHrefAction<T>;
export type DataTableAction<T> = DataTableRowAction<T> | DataTableMultiAction<T>;
