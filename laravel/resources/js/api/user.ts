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


