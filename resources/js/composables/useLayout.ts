import { Arrayable } from '@vueuse/core';
import { h as baseH, Component, VNode } from 'vue';
import { ComponentProps } from 'vue-component-type-helpers';

type Renderer<T extends VNode> = (
    h: typeof baseH,
    page: VNode,
) => T & {
    inheritAttrs?: boolean;
};
type LayoutComponent = Component & {
    layout?: Renderer<VNode> | Arrayable<VNode>;
};

export function useLayout<T extends LayoutComponent>(component: T, props: () => ComponentProps<T>): Renderer<VNode> {
    return (h, page) => {
        const child = h(component, props(), () => page);

        if (component.layout && typeof component.layout === 'function') {
            const parent = component.layout(h, child);
            return h(parent, parent.props ?? {}, () => child);
        }

        return child;
    };
}

export function useLayouts(renderers: Renderer<VNode>[]): Renderer<VNode> {
    return (h, page) => {
        return renderers.toReversed().reduce((child, renderer) => {
            return renderer(h, child);
        }, page);
    };
}
