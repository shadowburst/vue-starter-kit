import { LucideIcon } from 'lucide-vue-next';
import { VNode } from 'vue';

export type DataTableTab = 'table' | 'card';

type DataTableRowBaseAction<T> = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean | ((item: T) => boolean);
};
export type DataTableRowHrefAction<T> = DataTableRowBaseAction<T> & {
    type: 'href';
    href: string | ((item: T) => string);
};
export type DataTableRowCallbackAction<T> = DataTableRowBaseAction<T> & {
    type: 'callback';
    callback: (item: T) => void;
};
export type DataTableRowCustomAction<T> = {
    type: 'custom';
    component: (item: T) => VNode;
};
export type DataTableRowAction<T> =
    | DataTableRowCallbackAction<T>
    | DataTableRowCustomAction<T>
    | DataTableRowHrefAction<T>;

export type DataTableRowsAction<T> = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean | ((items: T[]) => boolean);
    callback: (items: T[]) => void;
};
