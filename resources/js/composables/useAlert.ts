import { injectAlertModalContext } from '@/components/ui/custom/alert-modal';

export function useAlert() {
    const { alert } = injectAlertModalContext();

    return alert;
}
