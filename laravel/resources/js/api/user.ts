import type { User } from "../models/user.model"
import { apiClient } from "../utils/apiClient";
import { getListOfClubManagers } from "./club";
import { getListOfRaidManagers } from "./raid";

export const getUser = async (): Promise<User> => {
    return apiClient<User>('/user', {
        method: 'GET'
    });
}

export const isClubManager = async (userId: string) => {
    const listManager = await getListOfClubManagers()
    return listManager.includes(userId);
}

export const isRaidManager = async (userId: number) => {
    const listManager = await getListOfRaidManagers()
    return listManager.includes(userId);
}
    