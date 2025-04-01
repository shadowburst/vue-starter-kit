import { createContext } from 'reka-ui';

export type AppAlertDialogState = {
    type: 'info' | 'success' | 'warning' | 'danger';
    title?: string;
    description?: string;
    footnote?: string;
    callback?: () => void;
};

export const [useAlert, provideAppAlertDialog] =
    createContext<(state: Partial<AppAlertDialogState>) => void>('app-alert-dialog');
