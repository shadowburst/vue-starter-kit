import type { CallbackActionItem, CustomActionItem, HrefActionItem } from './interface';

export function createActionItemHelper<T>() {
    return {
        href(options: Omit<HrefActionItem<T>, 'type'>): HrefActionItem<T> {
            return {
                type: 'href',
                ...options,
            };
        },
        callback(options: Omit<CallbackActionItem<T>, 'type'>): CallbackActionItem<T> {
            return {
                type: 'callback',
                ...options,
            };
        },
        custom(options: Omit<CustomActionItem<T>, 'type'>): CustomActionItem<T> {
            return {
                type: 'custom',
                ...options,
            };
        },
    };
}
