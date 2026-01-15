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

export const updateUser = async (userId: number, data: Partial<User>) => {
    return await apiClient<User>(`/users/${userId}`, {
        method: 'PUT',
        body: JSON.stringify(data)
    });
}


