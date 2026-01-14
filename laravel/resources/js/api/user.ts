import type { User } from "../models/user.model"
import { apiClient } from "../utils/apiClient";

export const getUser = async (): Promise<User> => {
    return apiClient<User>('/user', {
        method: 'GET'
    });
}

export const getUsersByClub = async (clubId: number): Promise<User[]> => {
    const response = await apiClient<{ data: User[] }>(`/clubs/${clubId}/users`, {
        method: 'GET'
    });
    return response.data;
}
