import { apiClient } from "../utils/apiClient";
import type { User } from "../models/user.model";

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
