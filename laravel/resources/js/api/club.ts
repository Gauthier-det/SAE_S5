import { apiClient } from "../utils/apiClient";
import type { User } from "../models/user.model";
import type { Club } from "../models";

export interface ClubResponse {
    data: Club;
}

export interface ClubUsersResponse {
    data: User[];
}

export const getListOfClubs = async (): Promise<Club[]> => {
    const response = await apiClient<{ data: Club[] }>('/clubs');
    return response.data;
};

export const getListOfClubManagers = async (): Promise<number[]> => {
    const clubs = await getListOfClubs();
    return clubs.map((club) => club.USE_ID);
};

export const getUsersByClub = async (clubId: number): Promise<User[]> => {
    const response = await apiClient<{ data: User[] }>(`/clubs/${clubId}/users`, {
        method: 'GET'
    });
    return response.data;
}

export const getClub = async (id: number): Promise<Club> => {
    const response = await apiClient<ClubResponse>(`/clubs/${id}`);
    return response.data;
};

export const getClubUsers = async (id: number): Promise<User[]> => {
    const response = await apiClient<ClubUsersResponse>(`/clubs/${id}/users`);
    return response.data;
};

export const createClub = async (data: any): Promise<Club> => {
    const response = await apiClient<{ data: Club }>('/clubs', {
        method: 'POST',
        body: JSON.stringify(data)
    });
    return response.data;
}

export const createClubWithAddress = async (data: any): Promise<Club> => {
    const response = await apiClient<{ data: Club }>('/clubs/with-address', {
        method: 'POST',
        body: JSON.stringify(data)
    });
    return response.data;
}

export const updateClub = async (id: number, data: any): Promise<Club> => {
    const response = await apiClient<{ data: Club }>(`/clubs/${id}`, {
        method: 'PUT',
        body: JSON.stringify(data)
    });
    return response.data;
}

export const deleteClub = async (id: number): Promise<void> => {
    await apiClient(`/clubs/${id}`, {
        method: 'DELETE'
    });
}
