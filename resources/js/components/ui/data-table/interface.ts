import { LucideIcon } from 'lucide-vue-next';

export type DataTableAction<T> = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean | ((item: T) => boolean);
} & ({ href: string } | { callback: (item: T) => void });

export type DataTableMassAction<T> = {
    label: string;
    icon: LucideIcon;
    disabled?: boolean | ((items: T[]) => boolean);
    callback: (items: T[]) => void;
};
