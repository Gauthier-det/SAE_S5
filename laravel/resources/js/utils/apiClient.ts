export const BASE_URL = '/api';

interface RequestConfig extends RequestInit {
    token?: string;
}

export const apiClient = async <T>(endpoint: string, { token, ...customConfig }: RequestConfig = {}): Promise<T> => {
    const headers: HeadersInit = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    } else {
        const storedToken = localStorage.getItem('token');
        if (storedToken) {
            headers['Authorization'] = `Bearer ${storedToken}`;
        }
    }

    const config: RequestInit = {
        ...customConfig,
        headers: {
            ...headers,
            ...customConfig.headers,
        },
    };

    const response = await fetch(`${BASE_URL}${endpoint}`, config);

    if (response.status === 401) {
        localStorage.removeItem('token');
        // window.location.href = '/login'; // Avoiding hard reload/redirect here to let Context handle it if possible
    }

    if (!response.ok) {
        try {
            const errorData = await response.json();
            throw new Error(errorData.message || response.statusText);
        } catch (e) {
            throw new Error(response.statusText);
        }
    }

    if (response.status === 204) {
        return {} as T;
    }

    return response.json();
};
