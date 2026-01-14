import type { Club } from "../models/club.model";
import { apiClient } from "../utils/apiClient";

export const getListOfClubs = async (): Promise<Club[]> => {
    return apiClient<Club[]>('/clubs');
};

export const getListOfClubManagers = async (): Promise<number[]> => {
    const clubs = await getListOfClubs();
    return clubs.map(club => club.USE_ID);
};