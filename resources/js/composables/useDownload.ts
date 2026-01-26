import { UrlMethodPair } from '@inertiajs/core';
import { useAxios } from '@vueuse/integrations/useAxios';
import { AxiosRequestConfig } from 'axios';

export function useDownload<T>(urlOrPair: string | UrlMethodPair, name: string, config?: AxiosRequestConfig<T>) {
    const url = typeof urlOrPair === 'string' ? urlOrPair : urlOrPair.url;
    const method = typeof urlOrPair === 'string' ? 'GET' : urlOrPair.method;

    const response = useAxios<Blob>(url, {
        method,
        ...config,
        responseType: 'blob',
    });

    response.then(({ data }) => {
        const blob = data.value;
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = name;
        link.click();
        URL.revokeObjectURL(link.href);
    });

    return response;
}
