import axios from 'axios';

export function useAxios() {
    let abortController: AbortController | undefined = undefined;

    const instance = axios.create({});

    instance.interceptors.request.use((config) => {
        abortController?.abort();
        abortController = new AbortController();

        return {
            signal: abortController.signal,
            ...config,
        };
    });

    return instance;
}
