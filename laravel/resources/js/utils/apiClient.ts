export const BASE_URL = '/api';

interface RequestConfig extends RequestInit {
    token?: string;
}


export class ApiError extends Error {
    public status: number;
    public data: any;

    constructor(message: string, status: number, data: any) {
        super(message);
        this.name = 'ApiError';
        this.status = status;
        this.data = data;
    }
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

    if (config.body instanceof FormData) {
        // Let the browser set the Content-Type with boundary for FormData
        if (config.headers && 'Content-Type' in config.headers) {
            delete (config.headers as any)['Content-Type'];
        }
    }

    const response = await fetch(`${BASE_URL}${endpoint}`, config);

    if (response.status === 401) {
        localStorage.removeItem('token');
        // window.location.href = '/login'; 
    }

    if (!response.ok) {
        try {
            const errorData = await response.json();
            throw new ApiError(errorData.message || response.statusText, response.status, errorData);
        } catch (e) {
            if (e instanceof ApiError) throw e;
            throw new ApiError(response.statusText, response.status, null);
        }
    }

    if (response.status === 204) {
        return {} as T;
    }

    return response.json();
};
