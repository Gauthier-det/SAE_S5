import type { User } from "../models/user.model";
import type { Login, Register, AuthAPIResponse } from "../models/auth.model";
import { apiClient } from "../utils/apiClient";

interface AuthResponse {
    token: string;
    user: User;
}

export const apiLogin = async (login: Login): Promise<AuthResponse> => {
    const response = await apiClient<AuthAPIResponse>('/login', {
        method: 'POST',
        body: JSON.stringify(login),
    });

    return {
        token: response.data.access_token,
        user: {
            USE_ID: response.data.user_id,
            USE_NAME: response.data.user_name,
            USE_LAST_NAME: response.data.user_last_name,
            USE_MAIL: response.data.user_mail,
            USE_GENDER: response.data.user_gender,
            USE_PHONE_NUMBER: response.data.user_phone ?? undefined,
            USE_BIRTHDATE: response.data.user_birthdate ?? undefined,
            USE_LICENCE_NUMBER: response.data.user_licence ?? undefined,
            address: response.data.user_address || undefined,
            club: response.data.user_club || undefined
        }
    };
}

export const apiRegister = async (register: Register): Promise<AuthResponse> => {
    const response = await apiClient<AuthAPIResponse>('/register', {
        method: 'POST',
        body: JSON.stringify(register),
    });

    return {
        token: response.data.access_token,
        user: {
            USE_ID: response.data.user_id,
            USE_NAME: response.data.user_name,
            USE_LAST_NAME: response.data.user_last_name,
            USE_MAIL: response.data.user_mail,
            USE_GENDER: response.data.user_gender,
            USE_PHONE_NUMBER: response.data.user_phone ?? undefined,
            USE_BIRTHDATE: response.data.user_birthdate ?? undefined,
            USE_LICENCE_NUMBER: response.data.user_licence ?? undefined,
            address: response.data.user_address || undefined,
            club: response.data.user_club || undefined
        }
    };
}

export const apiLogout = async (): Promise<void> => {
    return apiClient<void>('/logout', {
        method: 'POST',
    });
}
