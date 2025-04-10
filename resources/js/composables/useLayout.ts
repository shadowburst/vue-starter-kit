import { h as baseH, Component, VNode } from 'vue';
import { ComponentProps } from 'vue-component-type-helpers';

type Renderer<T extends VNode> = (h: typeof baseH, page: VNode) => T;

type ParentLayout = VNode & {
    layout?: Renderer<ParentLayout>;
};
type Layout = Component & {
    layout?: Renderer<ParentLayout>;
};

export function useLayout<T extends Layout>(layout: T, props: () => ComponentProps<T>): Renderer<VNode> {
    return (h, page) => {
        const parents: ParentLayout[] = [];

        let parent: ParentLayout | undefined = layout.layout?.(h, page);
        while (parent) {
            parents.push(parent);
            parent = parent.layout?.(h, page);
        }
        return parents.reverse().reduce(
            (child, current) => {
                return h(current, current.props ?? {}, () => child);
            },
            h(layout, props(), () => page),
        );
    };
}
