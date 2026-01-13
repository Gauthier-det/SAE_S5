import type { User } from "../model/db/userDbModel";
import type { Login, Register } from "../model/domain/authModel";
import { apiClient } from "../utils/apiClient";

interface AuthResponse {
    token: string;
    user: User;
}

export const apiLogin = async (login: Login): Promise<AuthResponse> => {
    const response = await apiClient<{ data: { user_id: number; user_name: string; user_last_name: string; user_mail: string; access_token: string; token_type: string } }>('/login', {
        method: 'POST',
        body: JSON.stringify({ mail: login.email, password: login.password }),
    });
    
    return {
        token: response.data.access_token,
        user: {
            USE_ID: response.data.user_id,
            USE_NAME: response.data.user_name,
            USE_LAST_NAME: response.data.user_last_name,
            USE_MAIL: response.data.user_mail,
            USE_PASSWORD: '',
        }
    };
}

export const apiRegister = async (register: Register): Promise<AuthResponse> => {
    const response = await apiClient<{ data: { user_id: number; user_name: string; user_last_name: string; user_mail: string; access_token: string; token_type: string } }>('/register', {
        method: 'POST',
        body: JSON.stringify({ 
            mail: register.email, 
            password: register.password,
            name: register.name,
            last_name: register.last_name
        }),
    });
    
    return {
        token: response.data.access_token,
        user: {
            USE_ID: response.data.user_id,
            USE_NAME: response.data.user_name,
            USE_LAST_NAME: response.data.user_last_name,
            USE_MAIL: response.data.user_mail,
            USE_PASSWORD: '',
        }
    };
}

export const apiLogout = async (): Promise<void> => {
    return apiClient<void>('/logout', {
        method: 'POST',
    });
}

