import { apiClient } from "../utils/apiClient";
import type { User } from "../models/user.model";
import type { ClubCreation } from "../models/club.model";

export interface Club {
    CLU_ID: number;
    CLU_NAME: string;
}

export interface ClubResponse {
    data: Club;
}

export interface ClubUsersResponse {
    data: User[];
}

export const getClub = async (id: number): Promise<Club> => {
    const response = await apiClient<ClubResponse>(`/clubs/${id}`);
    return response.data;
};

export const getClubUsers = async (id: number): Promise<User[]> => {
    const response = await apiClient<ClubUsersResponse>(`/clubs/${id}/users`);
    return response.data;
};

export const createClub = async (clubData: ClubCreation): Promise<Club> => {
    const response = await apiClient<ClubResponse>('/clubs', {
        method: 'POST',
        body: JSON.stringify(clubData),
        headers: {
            'Content-Type': 'application/json'
        }
    });
    return response.data;
};