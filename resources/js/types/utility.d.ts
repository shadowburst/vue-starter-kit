type ExtractSetupProps<T> = T extends { setup?(props: infer P, ...rest: any[]): any }
    ? P extends any
        ? P
        : never
    : never;
type ExtractConstructedProps<T> = T extends { new (...args: any[]): { $props: infer X } }
    ? X extends Record<string, any>
        ? X
        : never
    : never;
/**
 * The type of the component's props.
 */
export type PropsOf<T> = Pick<ExtractConstructedProps<T>, keyof ExtractSetupProps<T>>;
