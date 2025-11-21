import { injectAlertDrawerContext } from '@/components/ui/custom/alert-drawer';

export function useAlert() {
    const { alert } = injectAlertDrawerContext();

    return alert;
}
