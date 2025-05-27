import { debouncedWatch } from '@vueuse/core';
import { computed, toRefs } from 'vue';

type PaginationParams = {
    page: number;
    perPage: number;
};
export function usePagination(params: PaginationParams) {
    const { page, perPage } = toRefs(params);

    debouncedWatch([page, perPage], () => {}, 50);

    return {
        page,
        perPage: computed({
            get: () => perPage.value,
            set: (value: number) => {
                if (value != perPage.value) {
                    page.value = 1;
                }
                perPage.value = value;
            },
        }),
    };
}
