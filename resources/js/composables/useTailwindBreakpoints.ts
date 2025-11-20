import { breakpointsTailwind, useBreakpoints } from '@vueuse/core';

export function useTailwindBreakpoints(options?: Parameters<typeof useBreakpoints>[1]) {
    return useBreakpoints(breakpointsTailwind, options);
}
