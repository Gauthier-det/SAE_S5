import type { User } from "../models/user.model"
import { apiClient } from "../utils/apiClient";
import { getListOfClubManagers } from "./club";
import { getListOfRaceManagers } from "./race";
import { getListOfRaidManagers } from "./raid";

export const getUser = async (): Promise<User> => {
    return await apiClient<User>('/user', {
        method: 'GET'
    });
}

export const getAllUsers = async (): Promise<User[]> => {
    const response = await apiClient<{ data: User[] }>('/users', {
        method: 'GET'
    });
    return response.data;
}

export const isClubManager = async (userId: number) => {
    const listManager = await getListOfClubManagers()
    return listManager.includes(userId);
}

export const isRaidManager = async (userId: number) => {
    const listManager = await getListOfRaidManagers()
    return listManager.includes(userId);
}

export const isRaceManager = async (userId: number) => {
    const listManager = await getListOfRaceManagers()
    return listManager.includes(userId);
}

export const isAdmin = async () => {
    try {
        const response = await apiClient<{ is_admin: boolean }>('/user/is-admin');
        return response.is_admin;
    } catch (e) {
        console.error("Failed to check admin status", e);
        return false;
    }
}

export const updateUser = async (userId: number, data: Partial<User>) => {
    return await apiClient<User>(`/users/${userId}`, {
        method: 'PUT',
        body: JSON.stringify(data)
    });
}

export const deleteUser = async (userId: number): Promise<void> => {
    await apiClient<void>(`/users/${userId}`, {
        method: 'DELETE'
    });
}

export interface UserStats {
    racesRun: number;
    podiums: number;
    totalPoints: number;
}

export interface UserHistoryItem {
    date: string;
    raid: string;
    race: string;
    rank: string;
    points: number;
}

export const getUserStats = async (userId: number): Promise<UserStats> => {
    return await apiClient<UserStats>(`/user/stats/${userId}`, {
        method: 'GET'
    });
}

export const getUserHistory = async (userId: number): Promise<UserHistoryItem[]> => {
    const response = await apiClient<{ data: UserHistoryItem[] }>(`/user/history/${userId}`, {
        method: 'GET'
    });
    return response.data;
}

export const getFreeRunners = async (): Promise<User[]> => {
    const response = await apiClient<{ data: User[] }>('/users/free', {
        method: 'GET'
    });
    return response.data;
}


