import { LucideIcon } from 'lucide-vue-next';

export type DataTableRowAction<T> = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean | ((item: T) => boolean);
    href?: string;
    callback?: (item: T) => void;
} & (
    | {
          href: string;
          callback?: never;
      }
    | {
          href?: never;
          callback: (item: T) => void;
      }
);

export type DataTableRowsAction<T> = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean | ((items: T[]) => boolean);
    callback: (items: T[]) => void;
};
