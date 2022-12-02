import { BASE_URL } from "~/helpers";
import { AxiosRequestConfig } from "axios";
type PropertiesFetch<U> = {
    isLoading: boolean;
    error: null | U;
};
type UseFetchReturn<T, U> = {
    data: null | T;
    properties: PropertiesFetch<U>;
};
const useFetch = async <T, U extends object>(
    url: string,
    config: AxiosRequestConfig = {}
): Promise<UseFetchReturn<T, U>> => {
    let data = null;
    let isLoading = true;
    let error = null;

    const fetchData = async () => {
        try {
            const response = await BASE_URL.get<T | U>(`${url}`, config);
            data = response.data;
        } catch (error: unknown) {
            const { message } = error as Error;
            error = message;
        }
        isLoading = false;
    };

    await fetchData();

    return { data, properties: { isLoading, error } };
};

export { useFetch };
